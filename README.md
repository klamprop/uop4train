# ForgeBox
FORGEBox is an experimental prototype platform enabling Interactive courses on top of FIRE resources.

FORGEBox is a technology created and supported by the FP7 FORGE project. FORGEBox is the component that interconnects learning interactive content with FIRE resources. It comprises a set of services that will provide and host for example the interactive content of widgets, and interface with the FIRE resources via well-known FIRE APIs or with the Fed4FIRE portal. LMSs, eBooks and any future element that wishes to consume FORGE content, will need to discover reference points of widgets and Lab Courses descriptions. FORGEBox instantiations can provide the host of such interactive content.
running instance forgebox.eu/fb.

Staging environment forgebox.eu/staging.

##Developed with :
>HTML5

>CSS3

>PHP

>Javascript/Jquery

>MySQL Database

##Installation

Download the FORGEBox package from <a href="https://github.com/bakkostas/ForgeBox/archive/master.zip" target="_blank">here</a>.

Extract the package in the forder you want to install.

In the folder db_installation_script you can find the SQL script (filename : forgebox.sql).

Create a MySQL database and import the SQL script.

Now go back to the folder and rename the file conf.php.default to conf.php. The file found in folder functions.

###Open the conf.php and fill the adove variables :

>Database Host

>Database username

>Database password

>Database Name

>Site Installation

>Site Note Teaser

###If you want to login users with Google mail account you have to fill either the 

>CLIENT_ID

>CLIENT_SECRET

>APPLICATION_NAME

Finally you have to change for some folders the permissions to read/write.

###That folders are :

>attachments/epub_files

>attachments/scorm_files

>images

>temp

Your installation has finished.

###You can logged in as administrator with the demo account :

>username :  `admin@forgebox.eu`

>password : `admin`

#Copyright

The source code in this distribution is © Copyright 2014 University of Patras

