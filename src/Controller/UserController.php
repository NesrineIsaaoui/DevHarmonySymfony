<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, SessionInterface $session): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
    
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);
    
        if (!$user || !$this->isPasswordValid($user, $password) || $user->getRole() == "Enseignant") {
            return $this->render('user/login.html.twig', ['error' => 'Invalid email or password']);
        }
    
        $session->set('user_id', $user->getId());
        $session->set('user_name', $user->getNom() . ' ' . $user->getPrenom());
        $session->set('user_picture', $user->getImage());
        $session->set('user_role', $user->getRole());

        if ($user->getConfirmcode() != "verified") {
            $randomCode = rand(100000, 999999);
            $user->setConfirmcode($randomCode);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->sendEmail($user->getEmail(), "Verification Email", "Your Code is ". $randomCode);
            return $this->render('user/verify.html.twig');
        }else if($user->getRole() === 'ADMIN') {
            return $this->redirectToRoute('app_user_back_index');
        } else if($user->getStatus() === 'Desactive') {
            $randomCode = rand(100000, 999999);
            $user->setStatusCode($randomCode);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

                // Optional: send SMS with Twilio
                $twilioSid = 'AC50977c3984b064ffb395e2b40e287ed9';
                $twilioAuthToken = 'ee36c27a53a72f2d71e09c902441c885';
                $twilioPhoneNumber = '+21627438527';
                $twilio = new \Twilio\Rest\Client($twilioSid, $twilioAuthToken);
                $userPhoneNumber = '+21627438527';
                $twilio->messages->create(
                    $userPhoneNumber,
                    [
                        "from" => '+16178602915',
                        "body" => "Your verification code is: {$randomCode}"
                    ]
                );

            return $this->redirectToRoute('verification_sms');
        } else {
            return $this->redirectToRoute('app_home');
        }
    }
    
    #[Route('/login/prof', name: 'app_login_prof')]
    public function loginProf(Request $request, SessionInterface $session): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
    
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);
    
        if (!$user || !$this->isPasswordValid($user, $password) || $user->getRole() != "Enseignant") {
            return $this->render('user/loginProf.html.twig', ['error' => 'Invalid email or password']);
        }
    
        $session->set('user_id', $user->getId());
        $session->set('user_name', $user->getNom() . ' ' . $user->getPrenom());
        $session->set('user_picture', $user->getImage());
        $session->set('user_role', $user->getRole());

        if ($user->getConfirmcode() != "verified") {
            $randomCode = rand(100000, 999999);
            $user->setConfirmcode($randomCode);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->sendEmail($user->getEmail(), "Verification Email", "Your Code is ". $randomCode);
            return $this->render('user/verify.html.twig');
        }else if($user->getRole() === 'ADMIN') {
            return $this->redirectToRoute('app_user_back_index');
        } else if($user->getStatus() === 'Desactive') {
            $randomCode = rand(100000, 999999);
            $user->setStatusCode($randomCode);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

                // Optional: send SMS with Twilio
                $twilioSid = 'AC50977c3984b064ffb395e2b40e287ed9';
                $twilioAuthToken = 'ee36c27a53a72f2d71e09c902441c885';
                $twilioPhoneNumber = '+21627438527';
                $twilio = new \Twilio\Rest\Client($twilioSid, $twilioAuthToken);
                $userPhoneNumber = '+21627438527';
                $twilio->messages->create(
                    $userPhoneNumber,
                    [
                        "from" => '+16178602915',
                        "body" => "Your verification code is: {$randomCode}"
                    ]
                );

            return $this->redirectToRoute('verification_sms');
        } else {
            return $this->redirectToRoute('app_home');
        }
    }
    
    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->clear();
    
        return $this->redirectToRoute('app_login');
    }

    private function isPasswordValid(User $user, string $password): bool
    {
        return $password == $user->getMdp();
    }

#[Route('/verification_submit', name: 'verification_submit', methods: ['POST'])]
public function verificationSubmit(Request $request, SessionInterface $session): Response
{
    // Get the logged-in user from the session
    $userId = $session->get('user_id');
    $userRepository = $this->getDoctrine()->getRepository(User::class);
    $user = $userRepository->find($userId);

    if (!$user) {
        return $this->redirectToRoute('app_login');
    }

    $verificationCode = $user->getConfirmcode();
    $submittedCode = $request->request->get('verification_code');


    if ($verificationCode == $submittedCode) {
        $user->setConfirmcode('verified');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    return $this->render('user/verify.html.twig');
}

#[Route('/verification_submit_Sms', name: 'verification_submit_sms', methods: ['POST'])]
public function verificationSubmitSMS(Request $request, SessionInterface $session): Response
{
    $userId = $session->get('user_id');
    $userRepository = $this->getDoctrine()->getRepository(User::class);
    $user = $userRepository->find($userId);

    if (!$user) {
        return $this->redirectToRoute('app_login');
    }

    $verificationCode = $user->getStatusCode();
    $submittedCode = $request->request->get('verification_code');

    if ($verificationCode == $submittedCode) {
        $user->setStatus('Active');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }else {
        return $this->redirectToRoute('verification_sms');
    }
}

#[Route('/verification_sms', name: 'verification_sms', methods: ['POST'])]
public function verificationSms(Request $request, SessionInterface $session): Response
{
    return $this->render('user/verifySMS.html.twig');
}

#[Route('/verification_forget', name: 'verification_forget')]
public function verificationForget(Request $request, SessionInterface $session): Response
{
    if ($request->isMethod('POST')) {
        $email = $request->request->get('email');
        $session->set('email',$email);
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if ($user) {
            $randomCode = rand(100000, 999999);
            $user->setResetcode($randomCode);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $session->set('verification_code', $randomCode);
            $this->sendEmail($email, "Verification Code", "Your Code is ".$randomCode);
            return $this->render('user/forget.html.twig');
        }else {
            return $this->render('user/email.html.twig');
        }
    }

    return $this->render('user/email.html.twig');
}

function sendEmail($recipientEmail, $subject, $message)
{
    $transport = Transport::fromDsn('smtp://liliajemai00@gmail.com:ndgmocmircxvrxvg@smtp.gmail.com:587?encryption=tls');

    $streamContextOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ];
    $transport->getStream()->setStreamOptions($streamContextOptions);

    $mailer = new Mailer($transport);

    $email = (new Email())
        ->from("pidev@gmail.com")
        ->to($recipientEmail)
        ->subject($subject)
        ->text($message);

    $mailer->send($email);
}

#[Route('/forget', name: 'forget')]
public function forgetPassword(Request $request, SessionInterface $session): Response
{
    $verificationCode = $request->request->get('verification_code');
    $storedVerificationCode = $session->get('verification_code');
    $email = $session->get('email');
    $userRepository = $this->getDoctrine()->getRepository(User::class);
    $user = $userRepository->findOneBy(['email' => $email]);

    if ($verificationCode == $user->getResetcode()) {
        $randomPassword = substr(md5(uniqid(rand(), true)), 0, 8);
        $user->setMdp($randomPassword);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $this->sendEmail($email, "Password Reset", "Your new Password is ".$randomPassword);
        return $this->redirectToRoute('app_login');
    } else {
        // If the verification code does not match, render the same page with an error message
        return $this->render('user/forget.html.twig', ['error' => 'Invalid verification code. Please try again.']);
    }

    return $this->render('user/forget.html.twig');
}

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error
                }

                $user->setImage($newFilename);
            }
            $password = $user->getMdp();
            $hashedPassword = md5($password);
            $user->setMdp($hashedPassword);
            $verificationCode = rand(100000, 999999);
            $user->setConfirmcode((string)$verificationCode);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'User created successfully!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setStatus("Desactive");
        $entityManager->flush();
        return $this->redirectToRoute('app_logout');
    }
}
