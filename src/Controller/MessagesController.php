<?php

namespace App\Controller;

use PhpParser\Node\Expr\Cast\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MessagesController extends AbstractController
{
    
    public function space_in_blank(): String
    {
        return 'Uno o mas espacios estan en blanco';
    }

    public function password_no_match(): String{
        return 'Las contraseñas no coinciden';
    }

    public function password_change_completed(): String{
        return 'La contraseña cambio exitosamente';
    }

    public function email_already_exists(): string{
        return 'El correo electronico ya existe';
    }

    public function profile_update_completed(): string{
        return 'Se ha actualizado la informacion';
    }

    public function Do_not_match(): string{
        return 'Las contraseña no es correcta';
    }


    public function getSweetAlertSeccess(): array
    {
        return [
            "title" => "Exito",
            "icon" => 'success',
            "html" => 'La operacion se hizo exitosamente!',
            "posicion" => 'center',
            "timer" => 5000,
            "showConfirmButton"=> false
       ];
    } 


    public function getSweetAlertError(): array
    {
        return [
            "title" => "Error",
            "icon" => 'error',
            "html" => 'Algo ha salido mal!',
            "posicion" => 'center',
            "timer" => 5000,
            "showConfirmButton"=> false
       ];
    } 


}
