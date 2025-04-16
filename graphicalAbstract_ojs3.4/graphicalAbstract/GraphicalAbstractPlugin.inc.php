<?php
namespace APP\plugins\generic\graphicalAbstract;

use PKP\plugins\GenericPlugin;
use PKP\core\Application;

class GraphicalAbstractPlugin extends GenericPlugin {
    public function register($category, $path, $mainContextId = null) {
        if (!parent::register($category, $path)) return false;

        \HookRegistry::register('Template::Submission::Workflow::Tabs', [$this, 'addGraphicalAbstractTab']);
        return true;
    }

    public function addGraphicalAbstractTab($hookName, $args) {
        $templateMgr = $args[0];
        $output =& $args[2];

        $output .= '<li><a name="graphicalAbstract" href="#graphicalAbstract">Graphical Abstract</a></li>';
        $templateMgr->assign('graphicalAbstractTab', true);
        return false;
    }

    public function getDisplayName() {
        return __('plugins.generic.graphicalAbstract.displayName');
    }

    public function getDescription() {
        return __('plugins.generic.graphicalAbstract.description');
    }
}
