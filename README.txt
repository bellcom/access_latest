This module works with core content moderation to solve the following use case:

An editor edits content using content moderation, creating a new unpublished draft.
The editor needs a reviewer to approve the changes before publishing them.
The reviewer is a busy person or for some other reason cannot log into the Drupal site to review.

This module provides the editor with a link they can share to give the reviewer access to the Latest revision page.

Find the link on the 'Moderation Control' form when viewing the moderated entity's Latest version page. (Make sure Moderation Control is displayed in the bundle's Manage Display settings.)

The link is a hash that stays the same for each page, so if the editor makes more edits the reviewer will always have access to see the latest version of that page. The links do not expire, so this is not a high-security solution if your unpublished drafts need protection.