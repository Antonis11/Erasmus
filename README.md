# Erasmus Application System

This is a **Responsive Web Application** for managing Erasmus program applications.

## User Roles

The system has **three types of Users**: Visitor, Registered User and Administrator.

### Visitor
- Has access to all pages **except** `application.html` (registration is required for access).
- Can perform a quick check on `reqs.html` to see if they are eligible for the Erasmus program.
- Can register and upgrade to a **Registered User**.

### Registered User
- Has access to their profile and can edit all details **except** the Username.
- Can access `application.html` **only during the application period** and submit an application.

### Administrator
- Sets the Application Period.
- Can view all Applications and sort them using the following filters:
  - Descending order of Average in cources
  - Applications with a Percent of **70% or higher** in courses
  - Applications for a specific University
  - Decide which applications are accepted and announced the Results after the end of the Application Period
- Can view all available Universities and add new ones.
- Can view all Administrators and add new ones.

## Notes
- In `application.html`, the First University Option in the drop-down list has `university_id=1`, the Second has `university_id=2`, and the Third has `university_id=3`.
- To set the **initial administrator**, the registration must use the AM number **2022999999999**.

## Installation Instructions

To run the application locally, follow these steps:

1. Download and install **XAMPP** from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html).
2. Copy **all application files** into the folder: `\xampp\htdocs`.
3. Open the **XAMPP Control Panel**.
4. Start the **Apache** and **MySQL** modules.
5. Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin) and **import the provided Database files**.
6. Open [http://localhost/index.html](http://localhost/index.html) in your browser to run the application.
