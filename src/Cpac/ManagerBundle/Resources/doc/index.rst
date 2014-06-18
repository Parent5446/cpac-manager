===================
CPAC Manager Bundle
===================

This bundle is the only part that requires an account. It provides
an API and interface for vendors and attendees to submit applications
for various parts of the convention.

1. Requirements
===============

1.1. Functional Requirements
----------------------------

* A user must be able to create a new application for application types
  that are enabled.
* A user must be able to submit a created application if the application
  type is still enabled.
* A user must be notified when their application's status changes.
* A user must be able to submit payment for their applications when they
  are approved and when payment is required.
* A manager must be able to list all applications for application
  types he/she is allowed to view.
* A manager must be able to filter the list of applications by the state
  of the application, the user who submitted it, and/or the type of the
  application.
* A manager must be able to view details of a specific application if the
  application type is one he/she is allowed to view.
* A manager must be able to approve or deny an application if the application
  type is one he/she is allowed to approve.
* An administrator must be able to create new conventions, the application
  types underneath.
* An administrator must be able to specify the maximum number of approved
  applications for a type.
* An administrator must be able to specify if an application type requires
  payment.

1.2. Performance Requirements
-----------------------------

* The user interface must load for the first time in less than two seconds.
* The user interface must load for subsequent loads in less than one second.
* Updating an application, including making changes, submission, approval,
  denial, etc., must take less than two seconds.
* Requesting a list of applications must take less than five seconds.

2. Entity and Controller Overview
=================================

This bundle has three main entities, organized in the following hierarchy:

    Convention -> ApplicationType -> Application

Each entity is "owned" by the previous entity in the chain.

A convention is an individual convention. Usually there is only one per year,
but the only restriction is that conventions have unique start dates. Under
each convention, there are a number of application types, which have certain
characteristics that determine the submission process. Finally, each type has
applications that have been submitted by users.

Each entity maps into a controller that allows users to query entity information,
modify entities, and make new entities. There is really no special business
logic; users make changes to resources that map almost directly to changes in
the entity, and thus the database.

3. REST API
===========

This bundle provides a REST API that the front-end interacts with. All the controllers
make up this API.

Example: How to get information about an application

    /cons/{startDate}/{appType}/applications/{appId}

Here: {startDate} is the ISO date for the start of the convention; {appType} is the name
of the application type; {appId} is the integer application ID.

The API is made from a natural REST hierarchy, with the above example being the longest URI.
In other words, if you remove {appId} from the above path, you'd get a list of all
applications in a given type, rather than a specific application. If you were to remove
"applications", you would get information about the application type itself, and so on.
