<?php
import('lib.pkp.classes.handler.Handler');
import('classes.submission.SubmissionFileDAO');

class GraphicalAbstractTabHandler extends Handler {

    public function authorize($request, &$args, $roleAssignments) {
        import('lib.pkp.classes.security.authorization.internal.SubmissionAccessPolicy');
        $this->addPolicy(new SubmissionAccessPolicy($request, $args, $roleAssignments, 'submissionId'));
        return parent::authorize($request, $args, $roleAssignments);
    }

    public function initialize($request, $args) {
        parent::initialize($request, $args);
        AppLocale::requireComponents(LOCALE_COMPONENT_APP_SUBMISSION);
        $this->setupTemplate($request);
    }

    public function showTab($args, $request) {
        $submissionId = (int) $request->getUserVar('submissionId');
        $templateMgr = TemplateManager::getManager($request);
        $submission = Services::get('submission')->get($submissionId);

        $templateMgr->assign([
            'submissionId' => $submissionId,
            'graphicalAbstractUrl' => $submission->getData('GraphicalAbstract')
        ]);

        $templateMgr->display($this->getPluginPath() . '/templates/tab.tpl');
    }

    public function save($args, $request) {
        $submissionId = (int) $request->getUserVar('submissionId');
        $submission = Services::get('submission')->get($submissionId);
        $user = $request->getUser();

        import('lib.pkp.classes.file.TemporaryFileManager');
        $temporaryFileManager = new TemporaryFileManager();

        $tempFileId = $request->getUserVar('graphicalAbstractFile');
        $temporaryFile = $temporaryFileManager->getFile($tempFileId, $user->getId());

        if ($temporaryFile && in_array($temporaryFile->getFileType(), ['image/png', 'image/jpeg'])) {
            import('lib.pkp.classes.file.PublicFileManager');
            $publicFileManager = new PublicFileManager();
            $destDir = $publicFileManager->getContextFilesPath($submission->getContextId()) . '/graphicalAbstracts/';
            $publicFileManager->mkdir($destDir);

            $filename = uniqid('graphicalAbstract_') . '.' . pathinfo($temporaryFile->getOriginalFileName(), PATHINFO_EXTENSION);
            $publicFileManager->copyFile($temporaryFile->getFilePath(), $destDir . $filename);

            $url = Application::get()->getRequest()->getBaseUrl() . '/' . $publicFileManager->getContextFilesPath($submission->getContextId(), true) . '/graphicalAbstracts/' . $filename;

            $submission->setData('GraphicalAbstract', $url);
            Services::get('submission')->edit($submission, []);

            return new JSONMessage(true);
        }

        return new JSONMessage(false, __('plugins.generic.graphicalAbstract.uploadFailed'));
    }
}
