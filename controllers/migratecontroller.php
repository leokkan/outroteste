<?php

namespace Controllers;

use Lib\Controller;
use Lib\Migration;

/**
 * Controla funcionalidades relacioandas ao usuário.
 */
class MigrateController extends Controller {

    public function _index() {

        try {
            $count = Migration::migrate();

            $this->data['resultado'] = true;
            if ($count > 0) {
                $this->data['msg'] = "{$count} migrações aplicadas.";
            } else {
                $this->data['msg'] = "Sem novas migrações.";
            }
        } catch (\Exception $ex) {
            $this->data['resultado'] = false;
            $this->data['msg'] = $ex->getMessage();
        }
    }

}
