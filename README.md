ez-performance-measure-bundle
=============================

Console Scripts to measure Performance of eZ public API

Installation
------------

The project is currently not available by composer thus you need to clone it into you src directory.
In the main directory of your eZ publish project :
```
git clone https://github.com/kuborgh/ez-performance-measure-bundle.git src/Kuborgh/Bundle/MeasureBundle
```

Then you can add the Bundle to your EzPublishKernel
```
public function registerBundles()
    {
        $bundles = array(
            new FrameworkBundle(),
            new SecurityBundle(),
            ...
            new Kuborgh\Bundle\MeasureBundle\KuborghMeasureBundle(),
        );
        ...
```

Now you can configure the measurements in your config.yml
```
kuborgh_measure:
    content_type_measurer:
        measurer1:
            service: 'kuborgh_measure.measurer.contentservice'
```

Usage
-------

```
Usage:
 kb:measure:performance [-iter|--iterations[="..."]] [ctype]

Arguments:
 ctype                 eZ Content Type

Options:
 --iterations (-iter)  Amount of content objects to load and measure (default: 100)
 --help (-h)           Display this help message.
 --quiet (-q)          Do not output any message.
 --verbose (-v|vv|vvv) Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
 --version (-V)        Display this application version.
 --ansi                Force ANSI output.
 --no-ansi             Disable ANSI output.
 --no-interaction (-n) Do not ask any interactive question.
 --shell (-s)          Launch the shell.
 --process-isolation   Launch commands from shell as a separate process.
 --env (-e)            The Environment name. (default: "dev")
 --no-debug            Switches off debug mode.
 --siteaccess          SiteAccess to use for operations. If not provided, default siteaccess will be used

```

Example to make 10 tests with the "article" content type which is provided in the ez demo page.
```
sf kb:measure:performance --iterations 10 article
```


Build in measurers
------------------

The following measurer services are provided :

* ContentServiceMeasurer (kuborgh_measure.measurer.contentservice)<br>
  Measure the time to load a content object by if via ContentService::loadContent
* LocationContentServiceMeasurer (kuborgh_measure.measurer.locationconten)<br>
  First load location via SearchService::findLocations to retrieve the content id and load the content object via ContentService::loadContent
* SearchContent (kuborgh_measure.measurer.searchcontent)<br>
  Use SearchService::findContent

So if you want to use every measurer listed abvove you can use the following configuration:
```
kuborgh_measure:
    content_type_measurer:
        measurer1:
            service: 'kuborgh_measure.measurer.contentservice'
		measurer2:
			service: 'kuborgh_measure.measurer.locationcontent'
		measurer3:
			service: 'kuborgh_measure.measurer.searchcontent'
```

Build your own measurer
-----------------------

All Measurers need to implement the ```MeasurerInterface``` interface and available as a service.
You can use the ```AbstractMeasurer``` as a basis to start from.

```
class MyMeasurer extends AbstractMeasurer
{
	/**
     * Provide a human readable name for this measurer.
     *
     * @return string
     */
    public function getName()
    {
        return "ContentService::loadContent";
    }

    /**
	 * Load the given valueObject and return the loadtime.
	 *
	 * @param ValueObject $valueObject
	 *
	 * @return float
	 */
	public function measure(ValueObject $valueObject)
	{
		// measure load call
		$start = microtime(true);

		// ... your code for loading here

		return microtime(true) - $start;
	}
}
```