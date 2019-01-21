<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Professionnal;
use App\Entity\User;
use App\Form\ContactAdminType;
use Doctrine\Common\Persistence\ObjectManager;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @param Request         $request
     * @param ObjectManager   $manager
     * @param \Swift_Mailer   $mailer
     * @param LoggerInterface $logger
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contact-us", name="admin.contact")
     */
    public function contactAdmin(Request $request, ObjectManager $manager, \Swift_Mailer $mailer, LoggerInterface $logger): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactAdminType::class, $contact)->handleRequest($request);

        $user = $this->getUser();
        dump($user);

        if ($user instanceof Professionnal || $user instanceof User) {
            $contact->setUserInSession($user->getId());
        }

        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $this->getUser()) {
                $this->redirectToRoute('user.login');
            } else {
                $manager->persist($contact);

                $manager->flush();

                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'soomize91@gmail.com';                 // SMTP username
                    $mail->Password = 'u8u7ky00';                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('soomize91@gmail.com', 'Mailer');
                    $mail->addAddress($contact->getEmail(), $contact->getName());

                    //Content
                    $mail->isHTML();
                    $mail->Subject = $contact->getName().'Vous a contacté !';
                    $mail->Body = $contact->getSubject();
                    $mail->AltBody = 'Envoyé le '.$contact->getCreatedAt()->format('d/m/Y');

                    $mail->send();
                    $this->addFlash(
                        'success',
                        'Félicitation, votre email a bien été envoyé !');
                    $logger->info('Message envoyé de la part de '.$contact->getName());
                } catch (Exception $e) {
                    $this->addFlash(
                        'error',
                        'Une erreure est survénue, message non envoyé !'
                    );
                    $logger->info($contact->getName().$e->errorMessage());
                }
            }
        }

        return $this->render('booking/contact_admin.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
