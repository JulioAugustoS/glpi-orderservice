# Service Order Plugin - GLPI
This plugin is capable of generating a service order through the same type.

![Define filters](http://suporte.passaromarron.com.br:86/glpi/github/screen.PNG)

* Open a ticket for each bug/feature so it can be discussed
* Follow [development guidelines](http://glpi-developer-documentation.readthedocs.io/en/latest/plugins/index.html)
* Refer to [GitFlow](http://git-flow.readthedocs.io/) process for branching
* Work on a new branch on your own fork
* Open a PR that will be reviewed by a developer

# Setting the Service Order Print button on the ticket screen

In the file ticket.php in the folder inc look for the buttons to reopen the call and save the call as below:

In my case the reopen call button is on the line 4861 and the save ticket is on the line 5251 of the ticket.php file.

Just look for where these buttons are to add the tags below each one.

# Reopen ticket button.

![Define filters](http://suporte.passaromarron.com.br:86/glpi/github/1.PNG)

# Save ticket button.

![Define filters](http://suporte.passaromarron.com.br:86/glpi/github/2.PNG)

# Once this is done, the button will appear on the ticket detail page as shown below:

![Define filters](http://suporte.passaromarron.com.br:86/glpi/github/3.PNG)
