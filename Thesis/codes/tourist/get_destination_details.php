<?php
require_once '../db_connect.php';

header('Content-Type: text/html');

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $destinationId = intval($_GET['id']);
    
    // Get main destination details
    $query = "SELECT d.DestinationID, d.DestinationName, d.DestinationInfo, d.DestinationImage 
              FROM destination d
              WHERE d.DestinationID = ?";
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $destinationId);
    $stmt->execute();
    $result = $stmt->get_result();
    $destination = $result->fetch_assoc();
    
    if ($destination) {
        // Get amenities
        $amenitiesQuery = "SELECT a.Amenities 
                           FROM amenities a
                           JOIN amenities_destination ad ON a.AmenitiesID = ad.AmenitiesID
                           WHERE ad.DestinationID = ?";
        $amenitiesStmt = $conn->prepare($amenitiesQuery);
        $amenitiesStmt->bind_param("i", $destinationId);
        $amenitiesStmt->execute();
        $amenitiesResult = $amenitiesStmt->get_result();
        $amenities = $amenitiesResult->fetch_all(MYSQLI_ASSOC);
        
        // Get additional images
        $imagesQuery = "SELECT DestinationImageImage 
                          FROM destination_image 
                          WHERE DestinationID = ?";
        $imagesStmt = $conn->prepare($imagesQuery);
        $imagesStmt->bind_param("i", $destinationId);
        $imagesStmt->execute();
        $imagesResult = $imagesStmt->get_result();
        $additionalImages = $imagesResult->fetch_all(MYSQLI_ASSOC);
        
       

        echo '<div class="destination-modal-top-header">';
        echo '<div class="modal-logo-area">';
        echo '<img src="../image/logo.png" alt="TourEase Logo">'; 
        echo '<span>TourEase</span>'; 
        echo '</div>';
        echo '<span class="modal-search-icon"></span>'; 
        echo '</div>';
       
        
        echo '<article class="destination-details">';
        
        
        echo '<div class="destination-left-column">';
        
            
            echo '<div class="image-name-container">';
                
                if (!empty($destination['DestinationImage'])) {
                    $imageData = base64_encode($destination['DestinationImage']);
                    echo '<img src="data:image/jpeg;base64,' . $imageData . '" 
                        alt="' . htmlspecialchars($destination['DestinationName']) . '" 
                        class="destination-modal-main-image">'; 
                }
                
                echo '<h2 class="modal-title">' . htmlspecialchars($destination['DestinationName']) . '</h2>';
            echo '</div>'; 

            // Additional images (Gallery) - Moved here to be under the main image
            if ($additionalImages && count($additionalImages) > 0) {
                echo '<div class="modal-section-container gallery-section">'; 
                echo '<h3 class="modal-detail-section-title">Photos</h3>'; 
                echo '<div class="gallery">';
                foreach ($additionalImages as $image) {
                    if (!empty($image['DestinationImageImage'])) {
                        $imageData = base64_encode($image['DestinationImageImage']);
                        echo '<img src="data:image/jpeg;base64,' . $imageData . '" 
                            alt="Gallery image"
                            class="gallery-image">';
                    }
                }
                echo '</div>';
                echo '</div>'; 
            }

        echo '</div>'; // End destination-left-column

        // NEW: Right Column Wrapper for About, Location, and Amenities
        echo '<div class="destination-right-column">';

            // NEW: Combined container for About and Location
            echo '<div class="modal-section-container about-location-wrapper">';
                // About Section
                echo '<div class="about-section">'; // Removed modal-section-container as wrapper has it
                echo '<h3 class="modal-detail-section-title">About</h3>'; // Title with destination name
                echo '<p>' . nl2br(htmlspecialchars($destination['DestinationInfo'])) . '</p>';
                echo '</div>'; // End about-section

                // Location Section (inside about-location-wrapper)
                echo '<div class="location-section">'; 
                    echo '<h3 class="modal-detail-section-title">Location</h3>'; 
                    
                    // --- START: NEW Inner container for location content ---
                    echo '<div class="location-content-wrapper">'; // This is the new container
                        echo '<div class="modal-location-map">';
                        // New container ABOVE the button
                            echo '<div class="location-description-box">';
                                echo '<p>This destination is available for guided navigation.</p>';
                            echo '</div>';

                            echo '<button class="modal-book-btn" onclick="showNavigationMap(' . $destinationId . ')">Route</button>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>'; // End location-section

            echo '</div>'; // End about-location-wrapper

            // Amenities Section (now separate, outside about-location-wrapper)
            echo '<div class="modal-section-container amenities-section">'; 
                echo '<h3 class="modal-detail-section-title">Amenities</h3>'; 
                if ($amenities && count($amenities) > 0) {
                    echo '<ul class="modal-amenities-list">';
                    foreach ($amenities as $amenity) {
                        echo '<li>' . htmlspecialchars($amenity['Amenities']) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>No amenities listed.</p>';
                }
            echo '</div>'; // End amenities-section

        echo '</div>'; // End destination-right-column

        echo '</article>';
    } else {
        echo '<p class="error-message">Destination not found</p>';
    }
} else {
    echo '<p class="error-message">No destination specified</p>';
}
?>