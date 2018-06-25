<?php


namespace App\UI;


use App\Domain\Common\InvalidOperationException;
use App\Domain\Common\Utility;
use App\Domain\SharedKernel\Money;
use App\Domain\SnackMachine\SnackMachineRepository;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/snack-machine")
 */
class SnackMachineController extends Controller
{
    private $snackMachineRepository;

    public function __construct(SnackMachineRepository $snackMachineRepository)
    {
        $this->snackMachineRepository = $snackMachineRepository;
    }

    /**
     * @Route("/{id}", name="snack-machine-overview")
     */
    public function overview($id): Response
    {
        return $this->render('snack-machine.html.twig', [
            'snackMachine' => $this->snackMachineRepository->find($id),
        ]);
    }

    /**
     * @Route("/{id}/insert-money/{amount}", name="snack-machine-insert-money")
     */
    public function insertMoney(int $id, string $amount)
    {
        $money        = $this->getMoney($amount);
        $snackMachine = $this->snackMachineRepository->find($id);

        try {
            $snackMachine->insertMoney($money);
            $this->snackMachineRepository->save($snackMachine);
            $message = Utility::moneyToString($money->getAmount()) . ' inserted';
        } catch (InvalidOperationException $e) {
            $message = $e->getMessage();
        }

        $this->addFlash('info', $message);

        return $this->redirectToRoute('snack-machine-overview', ['id' => $snackMachine->getId()]);
    }

    /**
     * @Route("/{id}/buy-snack/{position}", name="snack-machine-buy-snack")
     */
    public function buySnack(int $id, int $position)
    {
        $snackMachine = $this->snackMachineRepository->find($id);

        try {
            $snackMachine->buySnack($position);
            $this->snackMachineRepository->save($snackMachine);
            $message = 'Snack #' . $position . ' bought';
        } catch (InvalidOperationException $e) {
            $message = $e->getMessage();
        }

        $this->addFlash('info', $message);

        return $this->redirectToRoute('snack-machine-overview', ['id' => $snackMachine->getId()]);
    }

    /**
     * @Route("/{id}/return-money", name="snack-machine-return-money")
     */
    public function returnMoney(int $id)
    {
        $snackMachine = $this->snackMachineRepository->find($id);

        try {
            $money = $snackMachine->returnMoney();
            $this->snackMachineRepository->save($snackMachine);
            $message = Utility::moneyToString($money->getAmount()) . ' returned';
        } catch (InvalidOperationException $e) {
            $message = $e->getMessage();
        }

        $this->addFlash('info', $message);

        return $this->redirectToRoute('snack-machine-overview', ['id' => $snackMachine->getId()]);
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