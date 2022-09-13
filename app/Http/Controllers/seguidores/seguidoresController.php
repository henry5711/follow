<?php

namespace App\Http\Controllers\seguidores;

use Illuminate\Http\Request;
use App\Core\CrudController;
use App\Models\seguidores;
use App\Models\User;
use App\Services\seguidores\seguidoresService;
/** @property seguidoresService $service */
class seguidoresController extends CrudController
{
    public function __construct(seguidoresService $service)
    {
        parent::__construct($service);
    }

    public function seguidos($id)
    {
      $seguidos=seguidores::where('user_id',$id)->get();
      foreach ($seguidos as $key) {
        $key->name_user=User::where('id',$key->user_id)->value('full_name');
        $key->photo_url_user=User::where('id',$key->user_id)->value('photo_url');
        $key->name_follow=User::where('id',$key->follow_id)->value('full_name');
        $key->photo_url_follow=User::where('id',$key->follow_id)->value('photo_url');

    }
      return ["list"=>$seguidos,"total"=>count($seguidos)];

    }

    public function seguidores($id)
    {
        $seguidos=seguidores::where('follow_id',$id)->get();
        foreach ($seguidos as $key) {
            $key->name_user=User::where('id',$key->user_id)->value('full_name');
            $key->photo_url_user=User::where('id',$key->user_id)->value('photo_url');
            $key->nickname_user=User::where('id',$key->user_id)->value('nick_name_user');
            $key->name_follow=User::where('id',$key->follow_id)->value('full_name');
            $key->photo_url_follow=User::where('id',$key->follow_id)->value('photo_url');
            $key->nickname_follow=User::where('id',$key->follow_id)->value('nick_name_user');

        }
        return ["list"=>$seguidos,"total"=>count($seguidos)];
    }
}
