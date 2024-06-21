# WP Webmaster

WP Webmaster is a kind of swiss army knife that gathers essential functions and settings for standard wordpress instances and limits the number of installed plugins noticeably. In my webdesigners and administrators life I often miss small functions like SMTP or SVG support, but don't want to bloat my plugin list for every little purpose. So I built a plugin with convient settings page and default configuration file for a secure, privacy focused webmastering. Feel free to use, fork and rearrange. 

## Functions

### Emails

Customize email headers like name and email address for all outgoing messages. These settings can be overwritten by other plugins. Block notfications sent to the main admin, when plugins, themes or the core is updated.

### SMTP

Send all emails via SMTP. Encryption like SSL or TLS is mandatory. Allow self-signed certificates for debugging only. Attention: server errors are shown in the frontend code directly!

### Login 

Setup a custom design for the login page. Choose your own logo above the login form and use credits in the footer beneath. Further styles are found in the assets folder of this plugin.

### Backend

Clean the backend of unnecessary entries in the admin bar and in the admin menu. Hide sensitive settings and update information from all users except the main admin.

### Branding

Creates a individual widget at the admins dashboard for messages to other editors. Furthermore brand the admin backend with a personal footer.

### Media Library

Allows admins to upload SVG images and corrects the incorrect display in the media library and frontend. Overrides the upload path for files set in the media settings.

### Object Storage

Enable AWS S3 third party compatibility. Overwrites the default AWS endpoint for compatibility with providers like IONOS or OVHcloud. Human Made Plugin S3 Uploads required.

### Security

Lockdown brute force attacks, disable login with usernames which can be read plain at the authors archives or restrict admin creation to admins only even though editors are setup to create users too.

### Privacy

Mask email addresses and phone numbers for spam protection by encoding them with ASCII codes. Extend YouTube links with no-cookie-request and disable Google Fonts.

### Code

Inject code snippets sitewide into the header or footer and clean the code from unnecessary HTML for performance or security reasons, e.g. disable xmlrpc.php unless you require it for remote publishing or the Jetpack plugin.

### Development

Options for developing purposes. Not recommended for productive environments.

## Changelog

### 1.5
- Feature: Prevent individual defined categories from being displayed as blog posts at the frontend.
- Fix: Merging default, config, and current settings with error handling when option is not in the database
### 1.4
- Feature: Login lockdown for brute force attacks by blocking IPs for 24 hours after 3 failed login attempts
- Log blocked ips to a seperate file
- Function to unblock all blocked IPs
### 1.3
- Feature: Log email actions in separate file
- Advanced output of email errors via alert for debugging purposes
### 1.2
- Feature: Test mail for email and smtp settings 
### 1.1
- Feature: Inject code snippets e.g. for tracking
- Limit injection to not logged in users only
- Little code cleaning
### 1.0
- Initial Public Release

## License

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any latter version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
