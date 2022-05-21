# ATWD2 Assignment Report

## Stream vs DOM

A DOM parser takes an entire document and stores it within memory, where as a streaming parser reads a document line by line, with a pointer to indicate the current line that is being read. There are benefits to both types of parsing, and depending on the use case, will determine which is more useful.

### DOM

DOM parsers (such as SimpleXML for PHP) store all of the data objects and represents them in a tree structure. It is only loaded in once; after this it is available for the user to manipulate and access as they please. For this reason, it is usually faster to read documents in via DOM processing.

As you also have access to the entire XML tree, you can also query the DOM by running XPath expressions, or running validation using XSD (XML Schemas). All of this means that using the DOM is preferred, however it's downside is that due to being loaded constantly, it requires much more memory.

### Stream

Mainly used for very large documents that make it impractical, or in some cases impossible to load into memory. While it is not possible to parse as freely as the DOM parser, it means that an XML file of any size is readable, and is likely the only available choice when dealing with Big Data.

While stream processing is slower than DOM processing, you are still able to load data in "chunks", which offers almost a hybrid of the two methods. Although, it is still not possible to query the data like the DOM; this is mainly done for performance purposes. An example of stream processing in PHP is the XMLReader library.

## How Charts could be Extended

The first way that the charts section of this project could be extended is to allow more customisation from the user, such as different pollution types (e.g. allow a scatter of all three nitric oxides - no, nox and no2) to allow visualisations of more data. Another way to improve this feature is to extend the date range from the 5 years used in this project. As new data becomes available, it could be run through the PHP scripts to cleanse, normalise and be inputted into the system in order to continually staying up-to-date.

As for the line graphs, it would be good to see all three of the pollutants (no, no2, nox) on the same graph. This way, the user can spot trends in how much of these three substances are in the air at a given time, and whether they are proportional of each other. This could identify the main culprit in the production of these substances, and therefore allow attempts to reduce this value.

## Summary of Learnt Outcomes

This project has collectively solved a number of real world issues, using multiple technologies:

- Cleansing of data in order to make processing much more efficient. We have programmatically created a script to read through all of this pollution data, removing entries that do not contain any useful data, and separating the remaining data into their respective monitoring stations.
- Normalising this data further into an XML format, only focussing on the data values that we are concerned with. Not only does this reduce the amount of data that we are required to process, reducing storage requirements, but also allows us to process these documents using powerful querying tools, such as XPath, XQuery.
- Validating this data using XSD. This allows us to ensure that only valid data will be accepted, and aids in allowing the maintenance of cleansed data, even when further entries are added.
- Using this clean data to generate meaningful visualisations that allow end users to clearly see what all of this data means. Huge amounts of data can be difficult to spot trends easily; graphics make this much simpler.



