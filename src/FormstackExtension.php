<?php

namespace Bolt\Extension\Mborn319\Formstack;

use Bolt\Extension\SimpleExtension;
use \JGulledge\FormStack\API\FormStack;

/**
 * ExtensionName extension class.
 *
 * @author Michael Born <mborn319@gmail.com>
 */
class FormstackExtension extends SimpleExtension
{
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
        $app = $this->getAll();
        if ( $app['debug'] ) {
            $formStack->setDebug();
        }

        // get the form
        $myForm = $formStack->loadForm( $form_id );
        $details = $myForm->getDetails();

        print( $details['html'] );

        
    }
}
