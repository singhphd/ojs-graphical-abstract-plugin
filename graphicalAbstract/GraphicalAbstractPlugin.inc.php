<?php
class GraphicalAbstractPlugin extends GenericPlugin {

    public function register($category, $path, $mainContextId = null) {
        $success = parent::register($category, $path, $mainContextId);
        if ($success && $this->getEnabled()) {
            HookRegistry::register('Template::Workflow::Submission::Tabs', [$this, 'addGraphicalAbstractTab']);
            HookRegistry::register('LoadComponentHandler', [$this, 'loadTabHandler']);

            // Display the graphical abstract on article and issue pages
            HookRegistry::register('TemplateManager::display', [$this, 'injectGraphicalAbstract']);
        }
        return $success;
    }

    public function getDisplayName() {
        return __('plugins.generic.graphicalAbstract.displayName');
    }

    public function getDescription() {
        return __('plugins.generic.graphicalAbstract.description');
    }

    public function addGraphicalAbstractTab($hookName, $args) {
        $output =& $args[2];
        $output .= '<li><a href="' . $this->getRequest()->getDispatcher()->url(
            $this->getRequest(),
            ROUTE_COMPONENT,
            null,
            'grid.graphicalAbstract.GraphicalAbstractTabHandler',
            'showTab',
            null,
            ['submissionId' => $args[1]->getId()]
        ) . '">' . __('plugins.generic.graphicalAbstract.tabName') . '</a></li>';
        return false;
    }

    public function loadTabHandler($hookName, $args) {
        if ($args[0] === 'grid.graphicalAbstract.GraphicalAbstractTabHandler') {
            import($this->getPluginPath() . '/GraphicalAbstractTabHandler.inc.php');
            return true;
        }
        return false;
    }

    /**
     * Inject the uploaded graphical abstract into article and issue templates.
     */
    public function injectGraphicalAbstract($hookName, $args) {
        $templateMgr = $args[0];
        $template = $args[1];
        $output =& $args[2];

        if ($template === 'frontend/objects/article_summary.tpl') {
            $article = $templateMgr->getTemplateVars('article');
            if ($article) {
                $url = $article->getData('GraphicalAbstract');
                if ($url) {
                    $injection = '<div class="graphical_abstract"><img src="' . $url . '" alt="Graphical Abstract"></div>';
                    $output = preg_replace('/(<\\h[1-6] class="title">.*?<\\/h[1-6]>)/s', "$1" . $injection, $output, 1);
                }
            }
        } elseif ($template === 'frontend/objects/article_details.tpl') {
            $article = $templateMgr->getTemplateVars('article');
            if ($article) {
                $url = $article->getData('GraphicalAbstract');
                if ($url) {
                    $injection = '<div class="graphical_abstract"><img src="' . $url . '" alt="Graphical Abstract"></div>';
                    $output = preg_replace('/(<h1 class="page_title">.*?<\/h1>)/s', "$1" . $injection, $output, 1);
                }
            }
        }

        return false;
    }
}
