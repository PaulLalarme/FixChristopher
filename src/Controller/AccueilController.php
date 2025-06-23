<?php

namespace App\Controller;

// On utilise le  bundle AbstractController avec ses composants response et route pour créer nos pages et les lier

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Mime\Email;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')] // On créé la accueil qui rendra une vue avec la fonction render
    // #[IsGranted('ROLE_VERIFIED')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }


    // #[Route("/insert", name: "new_user")] 
    //  function home ( EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    //  {
    //     $user = new User();
    //     $user ->setEmail('Louis@devaux.fr') 
    //             ->setRoles(['ROLE_USER'])
    //           ->setPassword($hasher->hashPassword($user,'0000'));
    //           $em->persist($user);
    //           $em->flush(); 
    //    return $this->render('accueil/index.html.twig');
    // }

    #[Route('/admin', name: 'app_admin')] // On créé la accueil qui rendra une vue avec la fonction render
    public function admin(): Response

    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('accueil/admin.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    
//     #[Route('/mail', name: 'app_mail')] // On créé la accueil qui rendra une vue avec la fonction render
//     public function mail(MailerInterface $mailer)   

//     {
//         try{
//             $email = (new Email())
//             ->from('Pierre@Buisson.fr')
//             ->to('christopherdevaux2@gmail.com')
//             ->subject('Cofirmez votre email')
//             ->text('Coucou');

//             $mailer->send($email);
//             return new Response('Email envoyé !');

//         }catch(TransportExceptionInterface $e){
//             return new Response('Erreur D\'envoi : ' . $e->getMessage());
//         }catch(\Exception $e){
//             return new Response('Exception PHP!'. $e->getMessage());


//     }

// }
}