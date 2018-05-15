<?php


namespace App\UI;


use App\Domain\Money;
use App\Domain\SnackMachine;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SnackMachineController extends Controller
{
    /**
     * @Route("/", name="snack-machine-overview")
     */
    public function overview(SessionInterface $session): Response
    {
        return $this->render('snack-machine.html.twig', [
            'snackMachine' => $this->getSnackMachine(),
        ]);
    }

    /**
     * @Route("/snack-machine/insert-money/{amount}", name="snack-machine-insert-money")
     */
    public function insertMoney(Request $request)
    {
        $amount = $request->get('amount');

        $snackMachine = $this->getSnackMachine();

        $money = $this->getMoney($amount);
        $snackMachine->insertMoney($money);

        $this->saveSnackMachine($snackMachine);

        return $this->redirectToRoute('snack-machine-overview');
    }

    /**
     * @Route("/snack-machine/buy-snack/{position}", name="snack-machine-buy-snack")
     */
    public function buySnack(int $position)
    {
        $snackMachine = $this->getSnackMachine();

        $snackMachine->buySnack($position);

        $this->saveSnackMachine($snackMachine);

        return $this->redirectToRoute('snack-machine-overview');
    }

    /**
     * @Route("/snack-machine/return-money", name="snack-machine-return-money")
     */
    public function returnMoney()
    {
        $snackMachine = $this->getSnackMachine();

        $money = $snackMachine->returnMoney();

        $this->saveSnackMachine($snackMachine);

        $this->addFlash('status', $money . ' returned');

        return $this->redirectToRoute('snack-machine-overview');
    }

    private function getSnackMachine(): SnackMachine
    {
        $snackMachine = $this->getDoctrine()->getRepository(SnackMachine::class)->findOneBy([]);

        if ($snackMachine === null) {
            $snackMachine = new SnackMachine();
        }

        return $snackMachine;
    }

    private function saveSnackMachine(SnackMachine $snackMachine): void
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($snackMachine);
        $manager->flush();
    }

    private function getMoney($amount): Money
    {
        switch ($amount) {
            case 'one-cent':
                $money = Money::Cent();
                break;
            case 'ten-cent':
                $money = Money::TenCent();
                break;
            case 'quarter':
                $money = Money::Quarter();
                break;
            case 'one-dollar':
                $money = Money::Dollar();
                break;
            case 'five-dollar':
                $money = Money::FiveDollar();
                break;
            case 'twenty-dollar':
                $money = Money::TwentyDollar();
                break;
            default:
                throw new RuntimeException('You cannot insert this money');
        }

        return $money;
    }

}