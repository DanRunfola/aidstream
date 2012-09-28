<?php

class Iati_Organisation_Element_OrganisationName extends Iati_Organisation_BaseElement
{
    //protected $isMultiple = true;
    protected $isRequired = true;
    protected $className = 'OrganisationName';
    protected $displayName = 'Organisation Name';
    protected $attribs = array('id' , 'name' , 'text' , 'xml_lang');
    protected $iatiAttribs = array('name' , 'text' , 'xml_lang');
    protected $tableName = 'organisation/name';
}