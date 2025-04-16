<?php
class GraphicalAbstractPlugin extends GenericPlugin {

    public function register($category, $path, $mainContextId = null) {
        $success = parent::register($category, $path, $mainContextId);
        if ($success && $this->getEnabled()) {
            HookRegistry::register('Template::Workflow::Submission::Tabs', [$this, 'addGraphicalAbstractTab']);
            HookRegistry::register('LoadComponentHandler', [$this, 'loadTabHandler']);
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
}
