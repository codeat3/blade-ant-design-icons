<?php

use Codeat3\BladeIconGeneration\IconProcessor;

class BladeAntDesignIcons extends IconProcessor {
    public function postOptimization()
    {
        $this->svgLine = str_replace('<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">', '', $this->svgLine);
        $this->svgLine = preg_replace('/\<\?xml.*\?\>/', '', $this->svgLine);
        $this->svgLine = str_replace('stroke="black"', 'stroke="currentColor"', $this->svgLine);
        $this->svgLine = str_replace('fill="black"', 'fill="currentColor"', $this->svgLine);

        return $this;
    }
}
$svgNormalization = static function (string $tempFilepath, array $iconSet) {

    $iconProcessor = new BladeAntDesignIcons($tempFilepath, $iconSet);
    $iconProcessor
        ->optimize()
        ->postOptimization()
        ->save();
};

return [
    [
        // Define a source directory for the sets like a node_modules/ or vendor/ directory...
        'source' => __DIR__.'/../dist/packages/icons-svg/svg/filled',


        // Define a destination directory for your icons. The below is a good default...
        'destination' => __DIR__.'/../resources/svg',

        // Enable "safe" mode which will prevent deletion of old icons...
        'safe' => true,

        // Call an optional callback to manipulate the icon
        // with the pathname of the icon and the settings from above...
        'after' => $svgNormalization,

        'is-solid' => true,
    ],
    [
        // Define a source directory for the sets like a node_modules/ or vendor/ directory...
        'source' => __DIR__.'/../dist/packages/icons-svg/svg/outlined',

        // Define a destination directory for your icons. The below is a good default...
        'destination' => __DIR__.'/../resources/svg',

        'output-suffix' => '-o',

        // Enable "safe" mode which will prevent deletion of old icons...
        'safe' => true,

        // Call an optional callback to manipulate the icon
        // with the pathname of the icon and the settings from above...
        'after' => $svgNormalization,

        'is-solid' => true,
    ],
];
