How to install
===============

The install procedure should be the same as most other XenForo addons. Here's how it works:

* Grab the latest ZIP from the GitHub [releases](https://github.com/lol768/XenForo-MCASSOC/releases) page.
* Upload everything in the `upload` folder to the root of your XenForo installation.
* You should now see a new `AssociationMc` folder in your library directory.
* Use the admin panel and the XML file provided in the ZIP to finalize the install.

Now the install is done and you should see the addon in your addons list. It's time to configure it:
* Go to the Home -> Options page in the ACP.
* Find the "Minecraft Association" settings page:
  * ![image](https://cdn.mediacru.sh/cx1LOGSM3xGV.png)
* You will *need to request* the shared secret and site id information. See [this page](http://mcassoc.lukegb.com/) for more info.
* The instance secret needs to be set to an even length hexadecimal string. This should be treated as a password.
* Save the settings.

Now the addon's link will be available in the profile dropdown. You can use this link to ensure everything is working.
Try associating your account. You should then be able to see the avatar in all your posts and on your profile page.