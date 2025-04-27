# Safa Cafe - Restaurant Management System

## Description

**Safa Cafe** is a restaurant management system designed to help restaurant owners manage their daily operations, including order processing, dish management, and staff management. The system allows customers to view the menu, place orders, and make reservations, while the restaurant admin can easily track and manage orders, dishes, and staff.

This project was developed as a web-based solution using HTML, CSS, Bootstrap, JavaScript for the frontend, and PHP with MySQL for the backend.

---

## Features

### For Admin:
- **Order Management**: Admin can view and update order statuses in real-time.
- **Dish Management**: Admin can add, update, and delete dishes from the menu, and manage their availability.
- **Reservation Management**: Admin can track and manage customer reservations.
- **Staff Management**: Admin can add, update, or remove staff members for restaurant operations.
  
### For Customers:
- **View Menu**: Customers can browse the menu, see dish details, and check availability.
- **Place Orders**: Customers can place orders for the dishes they like.
- **Reservation System**: Customers can reserve tables for dining at the restaurant.

---

## Technologies Used

- **Frontend**: HTML, CSS, Bootstrap, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Server**: XAMPP (Local Server: Apache + MySQL + PHP)
- **Database Management**: phpMyAdmin (for managing MySQL database)

---

## Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/Hassan-Zulfiqar/Safa-Cafe.git
   ```

2. **Install XAMPP**:
   - Download XAMPP from [Apache Friends](https://www.apachefriends.org/download.html).
   - Install XAMPP and start the **Apache** and **MySQL** servers.

3. **Set up the Database**:
   - Open **phpMyAdmin** from the XAMPP control panel.
   - Create a new database (e.g., `safa_cafe`).
   - Import the provided **SQL file** (located in the project folder) to set up the database structure.

4. **Configure the Project**:
   - Place the project files in the `htdocs` directory of your XAMPP installation (`C:\xampp\htdocs\`).
   - Ensure that the database connection settings in the PHP files are correctly configured to match your local MySQL settings.

5. **Access the Project**:
   - Open a browser and visit `http://localhost/Safa-Cafe` to start using the system.

---

## Usage

- **Admin Login**: Use the admin credentials to log in and manage orders, dishes, and staff.
- **Customer View**: Customers can visit the landing page to browse the menu and place orders or make reservations.

---

## Future Improvements

- **Multi-Vendor Support**: Adding support for multiple restaurants, where each restaurant will have its own menu and order management system.
- **Online Ordering Integration**: Implementing a delivery system or integration with online food delivery platforms.
- **Customer Account System**: Enabling customers to create accounts, track their order history, and save favorite dishes.

---

## Challenges Faced

- **Database Design**: Properly designing the database schema to handle multiple entities such as orders, dishes, reservations, and staff management.
- **User Authentication**: Ensuring proper access control for admins and customers to protect sensitive data.

---

## Accomplishments

- **Working Admin Panel**: A fully functional admin dashboard for managing restaurant operations.
- **Order Management**: A real-time order tracking system for both customers and admins.
- **Customer Interaction**: A smooth and easy-to-use interface for customers to browse and place orders.

---

## Conclusion

The **Safa Cafe** project aims to streamline the daily operations of restaurants and offer a seamless experience to both the restaurant staff and customers. This system is designed to help small and medium-sized restaurants efficiently manage their orders and reservations.

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
