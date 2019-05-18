<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 16/05/19
 * Time: 21:13
 */

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('test')
            ->setDescription('Comando test');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        // Euromillones
        $euromillonesDate = new \DateTime("last tuesday");

        $feedEuromillones = file_get_contents('https://www.loteriasyapuestas.es/es/euromillones/resultados/.formatoRSS');
        $feedEuromillones = str_replace('<media:', '<', $feedEuromillones);

        $rssEuromillones = simplexml_load_string($feedEuromillones);

        foreach ($rssEuromillones->channel as $channel) {
            foreach ($channel->item as $item) {
                $dateItem = new \DateTime($item->pubDate);
                if ($dateItem->format("Y/m/d") == $euromillonesDate->format("Y/m/d")) {
                    dump((string)$item->description);
                    die();
                    foreach ($item->description as $description) {
                        dump($description);
                        die();
                    }
                }
            }
        }
        die();
    }
}