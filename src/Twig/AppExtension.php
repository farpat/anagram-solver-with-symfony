<?php

namespace App\Twig;

use App\Services\ModuleService;
use App\Services\NavigationService;
use App\Services\Support\Str;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_asset', [$this, 'getAsset']),
        ];
    }

    public function getAsset(string $asset, bool $isAbsolute = false): string
    {
        static $json;

        if (!$isAbsolute) {
            return substr($asset, -4) !== '.css' ? "http://localhost:3000/assets/$asset" : '';
        } else {
            $publicPath = $this->parameterBag->get('kernel.project_dir') . '/public';
            $assetPath = $publicPath . '/assets';

            if (!$json) {
                $json = new Package(new JsonManifestVersionStrategy($assetPath . '/manifest.json'));
            }

            return $publicPath . $json->getUrl($asset);
        }
    }
}
