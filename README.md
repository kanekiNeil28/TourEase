# TOUREASE: TOURIST ASSISTANCE WITH QR BASED SYSTEM IN CALATAGAN, BATANGAS

## Authors
- *Susie Sam Atie Benson*
- *Alyssa Francin Dela Vega Eyay*
- *Neil Joshua Aniñon Simara*

## *Introduction*

This study focuses on developing a web and mobile application aimed at improving the tourism experience in Calatagan, Batangas. The system is intended for use by tourists and tourism authorities, aiming to enhance convenience, improve navigation, and streamline ecological fee payments. The system features four types of user accounts: tourist, eco police, barangay administrators, and municipal administrators. Tourists can search for resorts, view travel guidelines,map navigation, view recommendation of popular resorts,ratings and make ecological fee payments, while eco police are responsible for monitoring and enforcing compliance with tourism and environmental regulations. Barangay administrators oversee local tourism activities and ensure accurate information is provided, while municipal administrators manage the system at a higher level, ensuring efficient coordination between stakeholders and overseeing tourism operations.

To enhance the user experience, TourEase integrates several key features that contribute to a more efficient and informed travel experience. The Resort Locator allows tourists to find registered resorts and view important information such as location, amenities, and user reviews. The Interactive Map and Navigation provides real-time directions to major destinations, improving accessibility. The Emergency Assistance feature connects users with local responders, increasing safety during emergencies. Finally, the Ecological Fee Collection module allows for online payment and QR code verification which simplifies the fee monitoring process for tourism staff. The User Ratings feature allows tourists to leave reviews and rate resorts and attractions based on their experiences. This helps future travelers make informed decisions about where to stay or visit, ensuring transparency and reliability in the tourism industry. The Route & Transport Guide provides detailed directions to various destinations within Calatagan, including resorts, clinics, markets, and other municipal essential services.

The system also offers a Filtering Option on Amenities, enabling users to customize their searches based on their preferences. Tourists can filter resorts and accommodations based on specific criteria such as Wi-Fi availability, parking spaces, pet-friendly policies, swimming pools, beachfront access, and more. This feature ensures that visitors can easily find establishments that meet their needs and preferences. 

To further enhance navigation and accessibility, TourEase incorporates an Interactive Map & Navigation system. This feature allows users to view real-time locations of resorts, attractions, transport hubs, and emergency facilities, making it easier for tourists to plan their movements efficiently. The map provides step-by-step navigation, ensuring that travelers can explore Calatagan with ease.

## **Definition of Terms**
For better understanding of this study, the following terms are technically and operationally defined:
     
- **Amenities** - Facilities or services that provide comfort and convenience to tourists, such as swimming pool area, beach front, karaoke and other more.
-**Ecological Fee Collection** - A system feature that automates the payment of environmental fees.
- **Map.** - A visual representation used in the system to guide tourists to locations such as tourist spots, important landmarks, and municipal services.
- **Navigation.** - A feature in the system that helps tourists find their way by showing directions and guiding them to their desired destinations.
- **QR Code.** - A scannable code used to access digital content instantly.
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
