<?php
/**
 * File containing the Visitor class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\API\REST\Server\View;
use eZ\Publish\API\REST\Common;

use Qafoo\RMF;

/**
 * RMF visitor view
 */
class Visitor extends RMF\View
{
    /**
     * JSON visitor
     *
     * @var \eZ\Publish\API\REST\Common\Output\Visitor
     */
    protected $visitor;

    /**
     * Construct
     *
     * @param \eZ\Publish\API\REST\Common\Output\Visitor $visitor
     */
    public function __construct( Common\Output\Visitor $visitor )
    {
        $this->visitor = $visitor;
    }

    /**
     * Display the controller result
     *
     * @param RMF\Request $request
     * @param mixed $result
     * @return void
     */
    public function display( RMF\Request $request, $result )
    {
        if ( $result === null )
        {
            $message = new Common\Message(
                array( 'Status' => '200 No content', )
            );
        }
        else
        {
            $message = $this->visitor->visit( $result );
        }

        foreach ( $message->headers as $name => $value )
        {
            if ( $name === 'Status' )
            {
                // Special handling for PHP running as an Apache module
                header( $_SERVER['SERVER_PROTOCOL'] . ' ' . $value );
            }

            header( "{$name}: {$value}" );
        }
        echo $message->body;
    }
}

