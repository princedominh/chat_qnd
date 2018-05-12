<?php

namespace DMD\FrontBundle\Twig;

/**
 * Description of DMDTwigFrontExtension
 *
 * @author princedominh <princedominh@gmail.com>
 */
class DMDTwigFrontExtension extends \Twig_Extension
{
    private $environment;
    
    public function initRuntime(\Twig_Environment $environment) {
        $this->environment = $environment;
    }

    public function getName()
    {
        return 'dmd.twig.front_extension';
    }
    
    public function getFunctions()
    {
        return array(
            'dmd_pagination_render' => new \Twig_Function_Method($this, 'pagination'),
        );
    }

    public function pagination($paginationData, $router, $params = null, $extra = null)
    {
        
        $paginationData['last_page'] = ceil($paginationData['total_products'] / $paginationData['max_products']);
        $paginationData['previous_page'] = $paginationData['current_page'] > 1 ? $paginationData['current_page'] - 1 : 1;
        $paginationData['next_page'] = $paginationData['current_page'] < $paginationData['last_page'] ? $paginationData['current_page'] + 1 : $paginationData['last_page'];
        
        return $this->environment->render('DMDFrontBundle:Pagination:normal.html.twig', array(
            'router' => $router,
            'pagination' => $paginationData,
            'params' => $params,
            'extra' => $extra,
        ));
    }
}

