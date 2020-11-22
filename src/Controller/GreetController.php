<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/greeting")
 */

class GreetController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function sayHello(Request $request): Response
    {

        $number = random_int(0, 100);
        
        return new Response(
            '<html><body>
            Hello number '.$number
            .'<br>Name:'. $request->query->get('name')
            .'<br>Surname:'. $request->query->get('surname')
            .'<br><br><a href="'.$this->generateUrl('hello_number', ['number' => 100]).'">Goto numbers</a>
            </body></html>'
        );
    }

    /**
     * @Route("/bye/{number}", name="hello_number")
     */
    public function sayGoodbye(int $number): Response
    {
        return new Response (
            '<html><body>Goodbye number '.$number.'</body></html>'
        );
    }
}