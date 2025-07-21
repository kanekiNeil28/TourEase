# TOUREASE: TOURIST ASSISTANCE WITH QR BASED SYSTEM IN CALATAGAN, BATANGAS

## Authors
- *Susie Sam Atie Benson*
- *Alyssa Francin Dela Vega Eyay*
- *Neil Joshua Aniñon Simara*

## *Introduction*

## **Purpose**

The purpose of this study is to develop **TourEase: A Tourist Assistance System with QR Code in Calatagan, Batangas**. The main goal is to make the travel experience of tourists easier and more convenient. The system will help solve problems like the lack of organized information about tourist spots, difficulty in navigation, and the manual way of paying ecological fees. The system solves problems such as long lines for payments, lack of clear information, and difficulty in monitoring payments. TourEase also helps tourists find resorts, view guides, and get emergency assistance, making their visit to Calatagan more convenient. The study also aims to identify the issues faced by tourists and staff and evaluate the system’s usability and overall satisfaction.

## **Scope**

This study focuses on creating a web and mobile application for tourists visiting Calatagan. The system is intended for tourists and local tourism staff, including eco police, barangay administrators, and municipal administrators. Each user will have different roles in the system. For example, tourists can locate resorts, view travel guides, and pay ecological fees, while tourism staff can monitor transactions and generate reports. The system includes features like a resort locator, an interactive map for directions, emergency assistance, ecological fee collection, and a rating feature for tourists to review resorts. It also has a filter option to help tourists search for resorts with specific amenities such as Wi-Fi or beachfront access. However, the system is only designed for Calatagan and requires an internet connection to work. It supports only English and Tagalog, so foreign tourists may face language limitations.

## **Definition of Terms**
For better understanding of this study, the following terms are technically and operationally defined:
     
- **Amenities** - Facilities or services that provide comfort and convenience to tourists, such as swimming pool area, beach front, karaoke and other more.
-**Ecological Fee Collection** - A system feature that automates the payment of environmental fees.
- **Map.** - A visual representation used in the system to guide tourists to locations such as tourist spots, important landmarks, and municipal services.
- **Navigation.** - A feature in the system that helps tourists find their way by showing directions and guiding them to their desired destinations.
- **QR Code.** - A scannable code used to access digital content instantly.
- **Ratings.** A feedback mechanism in the system where tourists can evaluate resorts or tourist services based on their experiences using a scale 1 to 5 stars.
- **Resort Locator.**  A feature that helps tourists to locate accommodations with detailed information.
- **Smart Tourism.** - The integration of digital technology to enhance travel experiences and tourism management.
- **Software Usability Scale.** - A tool used to measure the ease of use and user satisfaction of a software system.
- **Stakeholders.** - The individual who use the system it includes tourist, eco police, barangay admin and municipality admin that will be the key stakeholders.
- **Tourist.** - A person who visits different places for fun, travel and relax.
- **Tourist Assistance System.** - A digital platform designed to help tourists navigate and access relevant information.

## **Overall Description** 

## *System Architecture*

<img width="989" height="559" alt="image" src="https://github.com/user-attachments/assets/ffff5b45-5be1-430c-9543-73ebaefc5b79" />


The system architecture of the proposed system, showcasing the interaction between various entities. The process starts when the tourist uses a mobile phone to make a payment through a payment gateway. After the payment is processed, a transaction receipt is created and sent to both the tourist and the eco police as proof of the transaction.
The system then sends all transaction details over the internet and stores them in the database. These stored details can be used later for checking records or generating reports.
The barangay admin and municipal admin can both access the system using a PC. The barangay admin manages Barangay Admin Accounts and receives a Barangay Report that shows local transaction data. Meanwhile, the municipal admin receives a Municipal Report that gives a bigger overview of all transactions across areas.
Tourists can also use the Map API to view locations and services. They can leave ratings based on their experience, and these ratings are also saved in the database for future use.
This setup makes sure that all payments are tracked, receipts are properly given, and both barangay and municipal admins can access the information they need for better planning and decision-making.

## Software and Tools Used

| Software         | Description                                | Specification          |
|------------------|--------------------------------------------|------------------------|
| Visual Studio Code | IDE for development and testing          | Windows 10             |
| XAMPP            | Local web server for PHP and database      | Apache + MySQL         |
| ReactJS/Native   | Framework for building user interfaces     | Latest Version         |
| HTML             | Markup language for web content            | Standard Version       |
| JavaScript       | Scripting language for dynamic features    | Standard Version       |
| PHP              | Server-side scripting language             | Latest Version         |

## *Use Case*

<img width="847" height="995" alt="image" src="https://github.com/user-attachments/assets/0d092009-11a8-46c0-b422-36af6e1b3bc2" />


The use case diagram for the proposed system. It represents the interaction between users and system, the actors are the Tourist, Eco Police, Barangay Admin and Municipal Admin. The diagram outlines the interactions between different users and system functionalities. The tourist can perform actions such as locating resorts, rate beach resorts and municipal essential services for guidance and paying the ecological fee through the system. The eco police have several responsibilities, including charging the ecological fee, validating transaction receipts, and managing eco policies to ensure proper environmental regulations are followed. The barangay admin manages barangay reports to track tourist transactions and ecological fee data while also being required to log in for secure access. Similarly, the municipal admin handles municipal reports for large-scale data analysis and must also log in to access relevant data securely. Both the barangay admin and municipal admin have the responsibility to manage eco policies to maintain proper enforcement at their respective levels. This use case diagram emphasizes the structured flow of tasks, ensuring efficient tourist assistance, ecological fee management, and accurate reporting for both barangay and municipal authorities.

## *Context Diagram*

<img width="973" height="606" alt="image" src="https://github.com/user-attachments/assets/51704e55-5945-4df9-a6bd-16277c447066" />


The context diagram of the system called "TourEase: Tourist Assistance with QR-Based System." This diagram shows how different users and external systems interact with TourEase by sending and receiving information.
In the system, tourists can view their current location and destination using the Map API. They can also pay ecological fees, receive digital receipts, and get information about places they want to visit.
The Eco Police provides their personal details to the system and submits transaction records from tourists. This helps them monitor and validate fee payments more easily.
The Barangay Admin shares their credentials and personal details with the system. In return, they receive reports related to tourist activities in their area. This helps them manage local tourism more efficiently.
The Municipal Admin also inputs their personal data and credentials. The system sends them reports that give a bigger picture of what's happening across the entire municipality.
The Map API connects with the system to give updated locations of tourists and tourist spots. This makes it easier for users to explore Calatagan safely and with accurate directions.

## *Data Flow Diagram*

<img width="985" height="622" alt="image" src="https://github.com/user-attachments/assets/f8935d23-4268-4724-8b6c-4283d7753d8e" />


The main users of the system are the Municipal Admin, Barangay Admin, Eco Police, Tourist, and MAP API.
The process starts with Manage Accounts, where the Municipal Admin, Barangay Admin, and Eco Police enter their credentials and personal information. This information is stored in the Accounts (D1) database for future use.
Next, the Generate Transaction Receipt process happens when the Eco Police submits transaction details, and the Tourist provides payment. After this, the system creates a receipt and saves the transaction in the Transactions (D2) database.
The Validate Receipt step allows the system to check if the receipt shown by the Tourist is valid and matches the saved transaction. If everything is correct, the Tourist can continue with their activities.
The View Location process helps the Tourist see their current location and other places using the MAP API. This makes it easier for tourists to move around and find destinations.
Finally, the Generate Reports process creates reports based on the saved transaction data. These reports are sent to both the Municipal Admin and Barangay Admin so they can monitor activities and keep track of records.

## *Entity-Relationship Diagram*

<img width="976" height="685" alt="image" src="https://github.com/user-attachments/assets/9616df70-5ae1-47d0-90b0-0d6678ada2ed" />


The proposed system's database structure, showing how different entities are connected. The Accounts table stores information about users, such as their name, username, email, password, and role like eco police. It is also connected to the Barangay table, which stores the name of each barangay.
The Destination table contains details about the tourist spots in Calatagan. This includes the name, description, image, and the exact location using latitude and longitude. Each destination can also have many images, which are saved in the Destination_Image table.
The Transaction table keeps track of tourist visits. It stores details like the guest name, how many guests are discounted or not, total fee, date of visit, and if the guest is a foreigner or made a booking. It is connected to both the Accounts and Destination tables.
Tourists can also give feedback through the Destination_Ratings table. This saves the rating (from 1 to 5) they give for each destination.
The system also includes information about Activities that tourists can do, like island hopping or snorkeling. These are stored in the Activities table, and linked to each destination through the Activities_Destination table.
The Amenities table lists features or services that a destination can offer, like Wi-Fi, beachfront, or parking. The Amenities_Destination table connects these amenities to specific destinations.
Lastly, the News table stores news or announcements. This includes the title, headline, body, image, and date. This helps inform users about updates, promos, or events in the area.

## *Constraits*

• The system requires an active internet connection, so it may not work well in areas with weak signals.

• It supports only English and Tagalog for now, limiting use by non-local or foreign tourists.

• Depends on regular updates from tourism authorities and resort owners to maintain accurate data.

• Limited user training: some users unfamiliar with QR-based systems may need guidance.

## *Limitations*

• The system is designed specifically for Calatagan, Batangas, so it’s not ready for other locations unless modified.

• No personalized AI-based recommendations; only basic suggestions and popular destinations.

• Offline mode and multi-language support are not yet implemented.

• Accuracy of maps and guides depends on integration with Maps API and local data.

## *Dependencies*

- **External Services:** - Maps API for navigation

- **Tourism Authorities:** -  For updated information on resorts, fees, and emergency contacts.

- **Device Requirements:** - Smartphones with camera for QR scanning, internet-enabled.

## **Specific Requirements** 

## *System Features*

**Resort Locator**

    Allows users to browse/search resorts in Calatagan with filters of amenities (e.g., beachfront, Wi-Fi, pool).
<img width="843" height="386" alt="resort locator" src="https://github.com/user-attachments/assets/f0cd511a-c626-4a24-859e-2865808189b0" />


<img width="843" height="382" alt="filter" src="https://github.com/user-attachments/assets/2be2a3f7-ddf2-440c-bfb5-8781cbddb139" />



**QR Code Generation**

    For receipt validation of Ecological fees.

![Qr Code](https://github.com/user-attachments/assets/a8f6620d-6dda-4665-ab55-6e6939f652f2)


**Interactive Map and Navigation**

    Uses Map Api to guide tourist in real-time to attractions and services.

<img width="526" height="366" alt="map" src="https://github.com/user-attachments/assets/922eec3b-5fe3-40f9-a380-81988e949da3" />


**Admin Reporting** 

    Barangay and Municipal admins monitor tourist data, reports, and fees collected.

<img width="843" height="384" alt="Dashboard" src="https://github.com/user-attachments/assets/68d27dfb-e165-4663-b2bb-407c37b6d364" />


**Rating System**

    Tourists can rate resorts (1–5 stars), helping future visitors.

<img width="843" height="382" alt="ratings" src="https://github.com/user-attachments/assets/f0a9da63-8863-4d28-90d0-ea8e8b53a4e6" />


## *Interface Requirements*

- Mobile-Friendly Interface (for Eco Police )
- Admin Web Interface (for Barangay and Municipal Admin)
- Tourist Web Interface (for Tourist)
- Map Integration UI
- Form Inputs (Basic forms for login, payment information, and transaction information.)


## *Non-Functional Requirements*

**Usability**
- Mobile and web interfaces must be user-friendly and easy to use including for the elderly or first-time visitors.

**Performance** 
- System should load resort information, maps on a stable internet connection.
- Mobile app must work smoothly on Android devices.

**Reliability**
- Admin dashboard should provide real-time reporting
- System should operate 24/7 especially during peak seasons (e.g., summer, holidays).

**Security**
- Passwords must be securely stored using hashing
- Role-based access control must be enforced:
    - Tourists access only front-end features (Ratings, Map Navigation, Resort Locator)
    - Eco police access transaction validation and transaction history.
    - Barangay and municipal admins access full reporting tools.

## *Other Requirements*

**Hardware Needed**
- Android Phone  - Use for testing the mobile app to ensure it works properly on devices commonly used by tourists
- Laptop/ PC  - Used for developing the system, coding, database management, and documentation.

**User Roles** 
- Tourist
- Eco Police
- Barangay Admin
- Municipal Admin


