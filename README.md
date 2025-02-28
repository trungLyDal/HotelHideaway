# Hotel Hideaway Booking System - Assignment 2

**Student Information**

* Name: Jun Ly
* Student ID: B00888214
* Date Created: 20/02/2025

**Application Type and Description**

Hotel Hideaway Booking System - This application is a web-based hotel booking system designed to provide a user-friendly experience for browsing and booking hotel rooms. The inspiration for this project comes from my interest in creating functional web applications with real-world applications. The design is influenced by the professional aesthetic of the [Start Bootstrap Business Casual theme](https://startbootstrap.com/previews/business-casual) and the grandeur of famous hotels (as seen on [UniqHotels Blog](https://www.uniqhotels.com/blog/the-biggest-hotels-in-the-world/)). The goal of this assignment is to demonstrate my ability to develop an interactive web application that incorporates server-side processing, data storage, and user interface design.

**Citations & Acknowledgements**

* [Start Bootstrap Business Casual Theme](https://startbootstrap.com/previews/business-casual) - Theme Bootstrap
* [UniqHotels Blog](https://www.uniqhotels.com/blog/the-biggest-hotels-in-the-world/) - Hotel Inspiration
* [Roxy Hotel NYC Deluxe Double](https://www.roxyhotelnyc.com/accommodations/deluxe-double/) - Room Detail Inspiration
* [Hotel Vilnia Classic Single Room](https://hotelvilnia.lt/accommodation/classic-single-room/) - Room Detail Inspiration
* [The Chatwal Suite](https://www.thechatwalny.com/stay/chatwal-suite/) - Room Detail Inspiration
* ChatGPT AI - Used to generate the `rooms.csv` file.
* [Dates and Times](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Date) - Get Date and Time
* [Form Validation](https://developer.mozilla.org/en-US/docs/Learn_web_development/Extensions/Forms/Form_validation) - Form Validation
* [Modal manipulation](https://developer.mozilla.org/en-US/docs/Web/API/HTMLDialogElement/showModal) - Show Modal
* [Session](https://www.php.net/manual/en/book.session.php) - Session to prevent double submission

**Steps to Set Up and Run the Application**

1.  Open the project folder.
2.  Set up a local web server (e.g., Apache, Nginx) with PHP installed.
3.  Place the project files in the web server's document root.
4.  Ensure `data/rooms.csv` and `data/bookings.csv` exist in the `data` directory.
5.  Open your web browser and navigate to the project's URL (e.g., `http://localhost/A2/tly/public/index.php`).
6.  Test the application's features.

**List of Features Implemented**

* **Room Search:**
    * Users can search for rooms by type (Single, Double, Suite, Royal).
    * Search results display available rooms with details.
* **Room Details:**
    * Detailed information for each room, including images, prices, and availability.
* **Booking System:**
    * Users can book available rooms by providing their name, check-in date, and check-out date.
    * **Confirmation Page:** A modal confirmation page will appear after the user clicks the submit button, that allows the user to confirm the information before submitting.

**Creative Element: User Story 5**
    **Confirmation Checklist:** Before the user can submit the form on the confirmation modal, the user must check all the checkboxes.
* **Double Submission Prevention:**
    * Implemented session-based prevention to avoid double form submissions on page reload.
* **Data Storage:**
    * Room and booking data are stored in CSV files (`rooms.csv` and `bookings.csv`).

**APIs Used and Their URLs**

* N/A (CSV files used for data storage)

**Any Additional Notes or Considerations**

* The `rooms.csv` file was generated using ChatGPT AI for demonstration purposes.
* The application uses Bootstrap, and PHP for its functionality.
* The application uses session variables to prevent double submissions.
* The application features a checklist that must be completed before a booking can be confirmed.