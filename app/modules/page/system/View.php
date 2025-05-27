<?php
class ModuleView extends View
{
//    public function contentPart()
//    {
//        switch (ACTION) {
//            case 'index':
//            case 'create':
//                echo $this->Content();
//                break;
//
//            default:
//                echo '<div class="menu-block">';
//                echo $this->Load('leftMenu');
//                echo $this->Content();
//                echo '</div>';
//        }
//
////        echo $this->Load('leftMenu'); //
////        echo $this->Content(); //
////        echo $this->Load('rightMenu'); //
//    }

    public function leftMenu()
    {
        if ($this->leftMenuAction)
            $action = $this->leftMenuAction;
        else
            $action = ACTION;

        $path = modulePath(CONTROLLER) . 'views/left/'.$action.'.php';
        if (file_exists($path)) {
            include_once($path);
        } else {
            $path = modulePath(CONTROLLER) . 'views/left/index.php';
            if (file_exists($path))
                include_once($path);
        }
    }

}

/* End of file */