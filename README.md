# Phing Library

This project will provide you some basic tasks which  are not part of the phing standard library.
For a list of standard phing features look at phing homepage http://www.phing.info

## Installation

Add the tasks and types to your project. The files should be placed relative to your build.xml file.
You can start the example build.xml file after cloning the GIT project.

## Examples
--------

See all example tasks:

    phing -f build.xml -l

i.E. run "soap_example" example task

    phing -f build.xml soap_example

Open the build.xml file to see how tasks and types are used.

## Included tasks

### Datetime

* TimestampTask

### JSON

* JsonPathTask

### Magento

* MagentoClearCacheTask
* MagentoCustomerTask
* MagentoGenerateLocalXmlkConfigTask
* MagentoVersionTask

### SOAP

* SoapCallTask

### Unix

* SetEnvTask

### XML

* XPathQueryTask

## Included types

* SoapClientType
* SoapParamType