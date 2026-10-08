<?php

declare(strict_types=1);

namespace App\Core\Views;

use App\Contracts\ViewSetInterface;
use Smarty\Exception;
use Smarty\Smarty;

class BaseViewSet implements ViewSetInterface
{
    private ?Smarty $smarty = null;

    /**
     * @throws Exception
     */
    public function render(string $view, array $data = []): string
    {
        $smarty = $this->getSmarty();
        $smarty->assign($data);

        return $smarty->fetch($view);
    }

    private function getSmarty(): Smarty
    {
        if ($this->smarty === null) {
            $basePath = dirname(__DIR__, 2);

            $this->smarty = new Smarty();
            $this->smarty->setTemplateDir($basePath . '/app/Templates');
            $this->smarty->setCompileDir($basePath . '/tmp/smarty/compile');
            $this->smarty->setCacheDir($basePath . '/tmp/smarty/cache');
            $this->smarty->setEscapeHtml(true);
        }

        return $this->smarty;
    }
}
