<?php

namespace App\Security\Voter;

use App\Entity\Users;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UsersVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'VIEW' , 'CREAT'])
            && $subject instanceof Users;
    }
   

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
     /** @var Users $subject */
        if($user->getRoles()[0] === 'ROLE_ADMIN_SYSTEM' &&
        ($subject->getRoles()[0] !== 'ROLE_ADMIN_SYSTEM'))
        {
         return true;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'CREAT':
                // logic to determine if the user can CREAT
                // return true or false

                if($user->getRoles()[0] === 'ROLE_ADMIN' &&
                    ($subject->getRoles()[0] === 'ROLE_CAISSIER'||
                     $subject->getRoles()[0] === 'ROLE_PARTENAIRE'))
                      {
                        return true;
                      }elseif($user->getRoles()[0] === 'ROLE_CAISSIER')
                      {
                        return false;
                      }
                if($userconnect->getRoles()[0] === 'ROLE_PARTENAIRE' &&
                    ($subject->getRoles()[0] === 'ROLE_ADMIN_PARTENAIRE'||
                    $subject->getRoles()[0] === 'ROLE_USER_PARTENAIRE'))
                       {
                         return true;
                       }
                
                break;
            case 'VIEW':
                // logic to determine if the user can VIEW
                // return true or false

                if($user->getRoles()[0] === 'ROLE_CAISSIER')
                {
                  return false;
                }
                break;
            case 'EDIT':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
