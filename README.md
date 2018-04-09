XenForo Minecraft Association Addon
====================================

[XenForo resource](https://xenforo.com/community/resources/associationmc.3232/). [Info on Minecraft username changes](https://xenforo.com/community/threads/associationmc.74920/#post-892880).

Minecraft association for XenForo. Uses the awesome [MCAssoc](http://mcassoc.lukegb.com/) service by lukegb.

Features
--------

* Displays Minecraft avatar and name on user's profiles and post sidebars (both threads and PMs).
* Customisable colours (see http://i.imgur.com/F1y2w2I.png for a dark example).
  * Default colours match XenForo's default theme.
  * You can customize the widget to ensure it fits in with your site.
* The system works by associating **Minecraft UUIDs** with XenForo user IDs.
* Includes support for user promotions and trophy awards based on whether a user has associated their account.
* Great for easily recognising in-game players on your forums and handling support requests.
* Association takes less than 30 seconds if the user already has an MCAssoc account.
  * Users without an existing account simply change their skin to one with encoded data (which does not impact their in-game skin at all - data outside visible region) via the provided link.
  * No need to collect usernames or passwords. No need for the user to be in-game or type in complicated commands.
  * Powered by lukegb's open-source, freely available [MCAssoc](https://mcassoc.lukegb.com/) service.
* Uses templates and phrases to ensure you can change the display of the addon.
* Easy to install.
* Works in conversations/private messages.

New Verification System
-----------------------

**Now setting up the addon is easier than ever!**

The shared secret is a required setting when configuring the addon and a new, completely automated system has been
introduced to allow for domains to be verified and shared secret keys to be generated on-demand. This replaces the old
system which required add-on users to send an email to lukegb. Many thanks to lukegb for his help getting these changes deployed.

1. Visit https://mcassoc.lukegb.com/
2. Enter the domain (where the forums are served from) you wish to verify in the right-hand textbox

![Screenshot](https://i.imgur.com/W7fwAUd.png)

3. Click the "Sign up" button
4. Decide how you want to verify your domain. At present, you can either create a HTML file or add a TXT record to your domain.
5. Follow the instructions and click the appropriate button to receive your shared secret.
6. Paste the shared secret into the Minecraft association options in XenForo's admin control panel.
7. Set the site ID to exactly what you typed into the textbox on the verification site.
8. Set the instance secret to a secret hexadecimal password (generate one [here](http://jsbin.com/jadofehoqu/1/))

Note: If you're using CloudFlare or enforcing SSL it is suggested you try the TXT record verification system *first*.

If you get stuck at any point and wish to have your domain manually verified, email mcassoc [at] lukegb [dot] com.

Screenshots
-----------

See [this](https://github.com/lol768/XenForo-MCASSOC/blob/master/SCREENSHOTS.md) page for screenshots.

Installing
----------

**You'll need PHP 5.4 or later.**

The install procedure should be the same as most other XenForo addons. Here's how it works:

* Grab the latest ZIP from the GitHub [releases](https://github.com/lol768/XenForo-MCASSOC/releases) page.
* From within the library folder of the root of your XenForo installation, create a folder named `AssociationMc`.
* Upload everything in the `upload` folder into `library/AssociationMc`, or the folder that was created previously.
* Use the admin panel and the XML file provided in the ZIP to finalize the install.

Now the install is done and you should see the addon in your addons list. It's time to configure it:
* Go to the Home -> Options page in the ACP.
* Find the "Minecraft Association" settings page:
  * ![image](https://i.imgur.com/t7u6mUN.png)
* You will *need to verify your domain to get the shared secret. See the above section ("New verification system") for information on how to do this.
* The instance secret needs to be set to an even length hexadecimal string. This should be treated as a password.
  * If you don't know what this means or would rather have a tool generate one for you, you can get an instance secret to use [here](http://jsbin.com/jadofehoqu/1/).
* Save the settings.

Now the addon's link will be available in the profile dropdown. You can use this link to ensure everything is working.
Try associating your account. You should then be able to see the avatar in all your posts and on your profile page.

Updating Usernames
----------
Navigate into the `library/Association` folder and execute command `php -f updateNames.php`. For large installations, this may take a long time and it's recommended to run it within a separate window.
