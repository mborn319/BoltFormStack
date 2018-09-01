<?php

namespace Bolt\Extension\Mborn319\Formstack;

use Silex\Application;
use Bolt\Extension\SimpleExtension;
use \JGulledge\FormStack\API\FormStack;

/**
 * ExtensionName extension class.
 *
 * @author Michael Born <mborn319@gmail.com>
 */
class FormstackExtension extends SimpleExtension
{
    /** @var Application */
    private $app;

    /** @var bool */
    protected $isDebugLoggedOffTurnedOn;

    /** @var bool */
    protected $isDebugTurnedOn;

    /**
     * {@inheritdoc}
     */
    protected function registerTwigFunctions() {
        return [
            'formstackEmbedForm' => 'formstackEmbedForm'
        ];
    }

    /**
     * Embed a Formstack form onto the page.
     * 
     * @return array
     */
    public function formstackEmbedForm( $form_id ) {
        $config = $this->getConfig();


        // begin Formstack API connection
        $apiConfig = array(
            'client_id'     => $config['api_client_id'],
            'client_secret' => $config['api_client_secret'],
            'redirect_url'  => $config['api_redirect_url'],
            'access_token'  => $config['api_access_token']
        );
        $formStack = new FormStack($apiConfig);

        // Duh - if debug is on, do debugging!
        if ( $this->isDebugMode() ) {
            $formStack->setDebug();
        }

        // get the form
        $myForm = $formStack->loadForm( $form_id );
        $details = $myForm->getDetails();

        print( $details['html'] );

        return new \Twig_Markup($details['html'], 'UTF-8');
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app) {
        parent::boot($app);

        $this->app = $app;

        $this->isDebugTurnedOn = $app['config']->get('general/debug', false);
        $this->isDebugLoggedOffTurnedOn = $app['config']->get('general/debug_show_loggedoff', false);

        $this->isUserLoggedIn = $app['session']->isStarted() && $app['session']->has('authentication');
    }

    protected function isDebugMode() {
        return $this->isDebugLoggedOffTurnedOn || ( $this->isDebugTurnedOn && $this->isUserLoggedIn ); 
    }
}
