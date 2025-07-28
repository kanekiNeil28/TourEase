<?php
require_once __DIR__ . '/../db_connect.php';

header('Content-Type: text/html');

if (isset($_GET['id'])) {
    $destinationId = intval($_GET['id']);
    
    // Get main destination details
    $query = "SELECT d.DestinationID, d.DestinationName, d.DestinationInfo, d.DestinationImage 
              FROM destination d
              WHERE d.DestinationID = ?";
    $stmt = $conn->prepare($query);
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
        
        // Start output
        echo '<article class="destination-details">';
        
        // Destination name
        echo '<h2>' . htmlspecialchars($destination['DestinationName']) . '</h2>';
        
        // Main image
        if (!empty($destination['DestinationImage'])) {
            $imageData = base64_encode($destination['DestinationImage']);
            echo '<img src="data:image/jpeg;base64,' . $imageData . '" 
                alt="' . htmlspecialchars($destination['DestinationName']) . '" 
                class="main-image">';
        }
        
        // Description
        echo '<div class="description">';
        echo '<h3>About</h3>';
        echo '<p>' . nl2br(htmlspecialchars($destination['DestinationInfo'])) . '</p>';
        echo '</div>';
        
        // Amenities
        if ($amenities && count($amenities) > 0) {
            echo '<div class="amenities">';
            echo '<h3>Amenities</h3>';
            echo '<ul>';
            foreach ($amenities as $amenity) {
                echo '<li>' . htmlspecialchars($amenity['Amenities']) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        
        // Additional images
        if ($additionalImages && count($additionalImages) > 0) {
            echo '<div class="gallery-section">';
            echo '<h3>Gallery</h3>';
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
        
        echo '</article>';
    } else {
        echo '<p class="error-message">Destination not found</p>';
    }
} else {
    echo '<p class="error-message">No destination specified</p>';
}
?>