XenForo Minecraft Association Addon
====================================

Minecraft association for XenForo. Uses the awesome [MCAssoc](http://mcassoc.lukegb.com/) service by lukegb.

Features
--------

* Displays Minecraft avatar and name on user's profile.
* Displays Minecraft avatar and name on user's posts.
* Customisable colours (see http://i.imgur.com/F1y2w2I.png for a dark example).
  * Default colours match XenForo's default theme.
 * You can customize the widget to ensure it fits in with your site.
* Association takes less than 30 seconds if the user already has an MCAssoc account.
  * Users without an existing account simply change their skin to one with encoded data (which does not impact their in-game skin at all - data outside visible region) via the provided link.
  * No need to collect usernames or passwords. No need for the user to be in-game.
  * Powered by lukegb's open-source [MCAssoc](http://mcassoc.lukegb.com/) service.
* Uses templates and phrases to ensure you can change the display of the addon.
* Easy to install.
* Works in conversations.

Screenshots
-----------

See [this](https://github.com/lol768/XenForo-MCASSOC/blob/master/SCREENSHOTS.md) page for screenshots.

Installing
----------

**You need PHP 5.4 or later.**

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
