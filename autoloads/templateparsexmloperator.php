<?
/*!
  \class   TemplateParseXMLOperator templateparsexmloperator.php
  \ingroup eZTemplateOperators
  \brief   Handles template operator parsexml
  \version 1.0
  \date    Tuesday 28 December 2004 1:02:09 pm
  \author  Administrator User

  By using parsexml you can ...

  Example:
\code
{$value|parsexml|wash}
\endcode
*/

include_once( 'lib/ezxml/classes/ezxml.php' );

class TemplateParseXMLOperator
{
    /*!
      Constructor, does nothing by default.
    */
    function TemplateParseXMLOperator()
    {
    	$this->Operators = array( 'parsexml' );
    }

    /*!
     \return an array with the template operator name.
    */
    function operatorList()
    {
         return $this->Operators;
    }
    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }
    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( 'parsexml' => array( 'first_param' => array( 'type' => 'string',
                                                                    'required' => false,
                                                                    'default' => 'default text' ) ) );
    }
    /*!
     Executes the PHP function for the operator cleanup and modifies \a $operatorValue.
    */
    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        $firstParam = $namedParameters['first_param'];

        switch ( $operatorName )
        {
            case 'parsexml':
            {
                $xmlText = $operatorValue;
                $fileAttachments=array();
				if ( trim( $xmlText ) != '' )
				{
					$xml = new eZXML();
					$dom = $xml->domTree( $xmlText );
					if ($dom)
					{
						$root = $dom->root('binaryfile-info');
						$binaryFile = $root->elementByName( 'binaryfile-attributes' );
						$FileAttribute = $binaryFile->elementByName(  $firstParam );
						$FileAttributeValue = $FileAttribute->attributeValue( 'value' );
					}
				}
                $operatorValue=$FileAttributeValue;
            } break;
        }
    }
}
?>

