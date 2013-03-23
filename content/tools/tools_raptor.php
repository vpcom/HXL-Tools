<span id="raptor"></span>
<h3>Raptor - TTL 2 RDF on Windows</h3>
<p>
    Raptor is a library providing with the necessary parser and serializer for converting a .ttl file into a .rdf.<br>
    On Windows this utility is not accessible via command line so they have to use Cygwin in order to emulate the UNIX shell command window.
</p>
<p>
    The intend of this section is to provide support for a windows installation because raptor works only on UNIX based computers. And in order to use it on windows, it is necessary to setup Cygwin with the necessary packages to configure, compile and install the library.
</p>
<p>
    The procedure shown below is not optimal because it downloads more packages than necessary. Nevertheless it is a simple way to be sure to have the packages allowing the use of make and those necessary to compile a C library.<br>
    The easy way is to install all the packages but it may take many hours (if not a whole day!), even with a fast Internet connection as of 2013 and with a useless bugged display of the download progress.<br>
    Otherwise repetitive errors may occur as well as a quest for understanding which package is missing.
</p>
<p>
    Follow the steps:
    <ul style="list-style-type: decimal;"> 
        <li>Download raptor</li>
        <li>Download cygwin</li>
        <li>Download a sample .ttl test file</li>
        <li>Download a sample cygwin script</li>
        <li>Install cygwin:
            <ul style="list-style-type: lower-latin;"> 
                <li>Select the Devel set</li>
                <li>Select all the packages coming with the search filter "gcc"</li>
            </ul>
        </li>
        <li>Then you can easily go through the rest of the process following the installation instruction on the raptor site</li>
    </ul>
</p>
<p>
    Links:
    <ul style="list-style-type: disc;"> 
        <li><a href="http://librdf.org/raptor/">Raptor RDF Syntax Library</a></li>
        <li><a href="http://www.cygwin.com/">Cygwin</a></li>
        <li><a href="http://www.webmonkey.com/2010/02/compile_software_from_source_code/">Compile Software From Source Code</a></li>
    </ul>
</p>
<br>
<br>
<br>