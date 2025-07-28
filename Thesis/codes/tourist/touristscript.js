  document.addEventListener('DOMContentLoaded', () => {
    // your carousel logic

  // --- Hero Section Background Carousel ---
      const heroBackgrounds = document.querySelectorAll('.hero-background-carousel img, .hero-background-carousel video');
      const circleNavItems = document.querySelectorAll('.circle-nav-item');
      let currentBgIndex = 0;

      function showHeroBackground(index) {
          heroBackgrounds.forEach((bg, i) => {
              if (i === index) {
                  bg.classList.add('active');
                  if (bg.tagName === 'VIDEO') { // Handles video backgrounds if present
                      bg.play();
                  }
              } else {
                  bg.classList.remove('active');
                  if (bg.tagName === 'VIDEO') {
                      bg.pause();
                      bg.currentTime = 0; // Reset video to start
                  }
              }
          });
          circleNavItems.forEach((item, i) => {
              if (i === index) {
                  item.classList.add('active');
              } else {
                  item.classList.remove('active');
              }
          });
      }

      function nextHeroBackground() {
          currentBgIndex = (currentBgIndex + 1) % heroBackgrounds.length;
          showHeroBackground(currentBgIndex);
      }

      // Auto-rotate background every 5 seconds
      setInterval(nextHeroBackground, 2000);

      // Click handler for circular navigation items
      circleNavItems.forEach(item => {
          item.addEventListener('click', () => {
              const index = parseInt(item.dataset.bgIndex);
              if (!isNaN(index)) {
                  currentBgIndex = index;
                  showHeroBackground(currentBgIndex);
              }
          });
      });

      // Initial background display
      showHeroBackground(currentBgIndex);

      // --- Header Animation ---
      const heroContent = document.querySelector('.hero-content');
      setTimeout(() => {
          heroContent.querySelector('h1').style.animationPlayState = 'running';
          heroContent.querySelector('p').style.animationPlayState = 'running';
          document.querySelector('.search-bar-container').style.animationPlayState = 'running';
      }, 200); // Small delay after page load
    
      document.addEventListener('DOMContentLoaded', () => {
      

          setupCarousel('destinationCards');
          setupCarousel('activitiesCards');
          setupCarousel('newsCards');
      });
      



      const searchInput = document.getElementById('searchInput');

  searchInput?.addEventListener('input', () => {
    const query = searchInput.value.trim().toLowerCase();

    const destinationCards = document.querySelectorAll('#destinationCards .destination-card');

    destinationCards.forEach(card => {
      const title = card.querySelector('.destination-title')?.textContent.toLowerCase() || '';
      const matches = title.includes(query);
      card.style.display = matches ? 'block' : 'none';
    });
  });

          // --- Header Animation ---
          const header = document.querySelector('.header');
  if (header) header.classList.add('header-text-visible');


      //document.addEventListener('DOMContentLoaded', function() {
          const cardsContainer = document.getElementById('destinationCards');
  });

  
  document.addEventListener('DOMContentLoaded', () => {
    let showAll = false;
    let allDestinations = [];

    const seeAllBtn = document.getElementById('seeAllBtn');
    const cardsContainer = document.getElementById('destinationCards');

    function escapeHtml(str) {
      return str.replace(/[&<>"']/g, function (m) {
        return {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#39;'
        }[m];
      });
    }

    function renderDestinations() {
      let html = '';
      const visible = showAll ? allDestinations : allDestinations.slice(0, 4);

      visible.forEach(destination => {
        const rating = destinationRatings[destination.DestinationID] || 4.5; // default to 4.5

        html += `
          <div class="destination-card">
            <div class="destination-image">
              <img src="data:image/jpeg;base64,${destination.ImageBase64}"
                  alt="${escapeHtml(destination.DestinationName)}"
                  class="card-img" loading="lazy">
              <div class="destination-overlay">
                <h3 class="destination-title">${escapeHtml(destination.DestinationName)}</h3>
                <p class="destination-location">📍 Calatagan, Batangas</p>
                <div class="destination-rating" data-rating="${rating}">
                  <div class="stars-outer">
                    <div class="stars-inner"></div>
                  </div>
                  <span class="rating-text">${rating}</span>
                </div>
                <button class="view-button explore-btn"
                        data-destination-id="${destination.DestinationID}">
                  View Resort
                </button>
              </div>
            </div>
          </div>
        `;
      });

      cardsContainer.innerHTML = html;
      initStarRatingInteraction?.();
      initModalHandlers?.();
      setStarWidths(); 
    }



    function setStarWidths() {
      document.querySelectorAll('.destination-rating').forEach(ratingEl => {
        const rating = parseFloat(ratingEl.dataset.rating) || 0;
        const percent = (rating / 5) * 100;
        const inner = ratingEl.querySelector('.stars-inner');
        if (inner) inner.style.width = `${percent}%`;
      });
    }





    seeAllBtn.addEventListener('click', () => {
      showAll = !showAll;
      renderDestinations();
      fetchAndDisplayLocations();
      seeAllBtn.textContent = showAll ? 'Show Less' : 'See All';
      setTimeout(() => {
      cardsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 300);
    });

    function fetchDestinations() {
      fetch('get_destination.php')
        .then(res => res.json())
        .then(data => {
          if (!data.success || !Array.isArray(data.data)) {
            throw new Error('Invalid format or data missing.');
          }
          allDestinations = data.data;
          return fetchRatings(); // <-- Load ratings
        })
        .then(() => {
          renderDestinations(); // <-- Render with ratings
          fetchAndDisplayLocations();
        })
        .catch(err => {
          console.error('❌ Failed to fetch destinations:', err);
          cardsContainer.innerHTML = `<p class="error-message">Failed to load destinations</p>`;
        });
    }


    fetchDestinations();

      //get and filter amenities 

        const modal = document.getElementById('amenitiesFilterModal');
        const openModalBtn = document.getElementById('filterButton');
        const closeModalBtn = document.querySelector('.close-filter-modal');
        const applyFilterBtn = document.getElementById('applyAmenitiesFilter');
        const clearFilterBtn = document.getElementById('clearAmenitiesFilter');
        const checkboxesContainer = document.getElementById('amenitiesCheckboxes');
        const destinationCardsContainer = document.getElementById('destinationCards');

        

        // 1. Show the modal when the button is clicked
        openModalBtn.addEventListener('click', () => {
            modal.style.display = 'block';

            fetchDestinations(); // ✅ refetch all destinations (unfiltered)

        });

        // 2. Close the modal
        closeModalBtn.addEventListener('click', () => {
          modal.style.display = 'none';
          showAll = false;
          fetchDestinations();
        });


        // 3. Make the modal draggable
        const header = modal.querySelector('.filter-modal-header');
        let isDragging = false;
        let offsetX = 0;
        let offsetY = 0;

        header.addEventListener('mousedown', (e) => {
          if (e.target.closest('.close-filter-modal')) return;

          isDragging = true;
          offsetX = e.clientX - modal.offsetLeft;
          offsetY = e.clientY - modal.offsetTop;

          modal.style.display = 'block';   // Ensure it's visible
          modal.style.position = 'fixed';  // Maintain fixed positioning
          document.body.style.userSelect = 'none';
        });

        document.addEventListener('mousemove', (e) => {
          if (!isDragging) return;

          const newLeft = Math.max(0, Math.min(window.innerWidth - modal.offsetWidth, e.clientX - offsetX));
          const newTop = Math.max(0, Math.min(window.innerHeight - modal.offsetHeight, e.clientY - offsetY));

          modal.style.left = `${newLeft}px`;
          modal.style.top = `${newTop}px`;
        });

        document.addEventListener('mouseup', () => {
          isDragging = false;
          document.body.style.userSelect = '';
        });

        // 4. Load amenities from backend
        fetch('get_amenities.php')
            .then(res => res.json())
            .then(data => {
                checkboxesContainer.innerHTML = '';
                data.forEach(amenity => {
                    const checkbox = document.createElement('div');
                    checkbox.innerHTML = `
                        <label>
                            <input type="checkbox" name="amenities[]" value="${amenity.AmenitiesID}">
                            ${amenity.Amenities}
                        </label>
                    `;
                    checkboxesContainer.appendChild(checkbox);
                });
            })
            .catch(err => console.error('Error loading amenities:', err));

        // 5. Apply filters

        let justAppliedFilter = false;
        
        applyFilterBtn.addEventListener('click', () => {
          justAppliedFilter = true; // ✅ this helps us avoid duplicate fetch

          const selected = Array.from(document.querySelectorAll('input[name="amenities[]"]:checked'))
              .map(cb => cb.value);

          if (selected.length === 0) {
            destinationCardsContainer.innerHTML = '<p>Please select at least one amenity.</p>';
            return;
          }

          fetch('filter_destinations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ 'amenities[]': selected })
          })
            .then(async res => {
              const text = await res.text();
              try {
                return JSON.parse(text);
              } catch (e) {
                console.error('❌ Failed to parse JSON. Raw response:', text);
                throw e;
              }
            })
            .then(data => {
              if (!data.success) throw new Error(data.message || 'Unknown error');
              allDestinations = data.data;
              showAll = true;
              renderDestinations();
             // modal.style.display = 'none'; // ✅ put this back
             fetchAndDisplayLocations();
            })
            .catch(err => {
              console.error('❌ Error fetching destinations:', err);
              destinationCardsContainer.innerHTML = '<p>Error fetching destinations.</p>';
            });
        });


        // 6. Clear filters
        clearFilterBtn.addEventListener('click', () => {
            document.querySelectorAll('input[name="amenities[]"]').forEach(cb => cb.checked = false);
            destinationCardsContainer.innerHTML = '<p>Filters cleared. Please apply again to see results.</p>';
        });

        // 7. Display destination cards
        function displayDestinations(destinations) {
            destinationCardsContainer.innerHTML = '';

            if (destinations.length === 0) {
                destinationCardsContainer.innerHTML = '<p>No destinations matched your selected amenities.</p>';
                return;
            }

            destinations.forEach(dest => {
                const card = document.createElement('div');
                card.classList.add('card');
                card.innerHTML = `
                    <h3>${dest.DestinationName}</h3>
                    <p>${dest.DestinationInfo || ''}</p>
                `;
                destinationCardsContainer.appendChild(card);
            });
        }

        //get_ratings
        let destinationRatings = {};

        function fetchRatings() {
          return fetch('get_ratings.php')
            .then(res => res.json())
            .then(data => {
              if (!data.success) throw new Error('Failed to load ratings');
              destinationRatings = data.ratings; // key: DestinationID, value: avg rating
            })
            .catch(err => {
              console.error('❌ Error fetching ratings:', err);
            });
        }


        function fetchAndDisplayLocations() {
        fetch('get_destination_locations.php')
          .then(res => res.json())
          .then(data => {
            if (!data.success) throw new Error('Failed to fetch locations');

            const locationMap = {};
            data.data.forEach(loc => {
              locationMap[loc.DestinationID] = loc.DestinationLocation;
            });

            document.querySelectorAll('.destination-card').forEach(card => {
              const btn = card.querySelector('.explore-btn');
              const id = btn?.dataset.destinationId;

              if (id && locationMap[id]) {
                const locEl = card.querySelector('.destination-location');
                if (locEl) {
                  locEl.textContent = `📍 ${locationMap[id]}, Calatagan Batangas`;
                }
              }
            });
          })
          .catch(err => {
            console.error('❌ Error setting locations:', err);
          });
      }



  });

  


          
      

  function initStarRatingInteraction() {
    const ratings = document.querySelectorAll('.destination-rating');

    ratings.forEach(ratingContainer => {
      const stars = ratingContainer.querySelectorAll('.star');
      const ratingText = ratingContainer.querySelector('.rating-text');

      stars.forEach(star => {
        star.addEventListener('click', () => {
          const value = parseInt(star.getAttribute('data-value'));
          ratingText.textContent = value.toFixed(1);

          stars.forEach(s => {
            const sVal = parseInt(s.getAttribute('data-value'));
            s.style.color = sVal <= value ? '#f1c40f' : '#777';
          });
        });
      });
    });
  }


          function initModalHandlers() {
              const exploreButtons = document.querySelectorAll('.explore-btn');
              const modal = document.getElementById('exploreModal');
              const modalContent = document.getElementById('modalContent');
              const closeModal = document.querySelector('.close-modal');

              exploreButtons.forEach(button => {
                  button.addEventListener('click', function() {
                      const destinationId = this.getAttribute('data-destination-id');
                      loadDestinationDetails(destinationId);
                  });
              });

              closeModal.addEventListener('click', function() {
                  modal.style.display = 'none';
              });

              modal.addEventListener('click', function(e) {
                  if (e.target === modal) {
                      modal.style.display = 'none';
                  }
              });
          }

          function loadDestinationDetails(destinationId) {
              const modal = document.getElementById('exploreModal');
              const modalContent = document.getElementById('modalContent');

              modalContent.innerHTML = '<div class="loading-spinner"></div>';
              modal.style.display = 'flex';

              fetch(`get_destination_details.php?id=${destinationId}`)
                  .then(response => response.text())
                  .then(data => {
                      modalContent.innerHTML = data;

                      // Add navigation button
                  const navButton = document.createElement('button');
                      navButton.addEventListener('click', () => {
                          showNavigationMap(destinationId);
                      });


                      // Find a good place to insert the button (after the gallery for example)
                      const gallery = modalContent.querySelector('.gallery');
                      if (gallery) {
                          gallery.after(navButton);
                      } else {
                          modalContent.appendChild(navButton);
                      }

                      // Add map container div (hidden by default)
                      const mapContainer = document.createElement('div');
                      mapContainer.id = 'navigationMapContainer';
                      mapContainer.style.display = 'none';
                      mapContainer.style.height = '400px';
                      mapContainer.style.marginTop = '20px';
                      mapContainer.style.borderRadius = '8px';
                      mapContainer.style.overflow = 'hidden';
                      modalContent.appendChild(mapContainer);

                      // Your existing gallery image click handlers
                      document.querySelectorAll('.gallery-image').forEach(img => {
                          img.addEventListener('click', function() {
                              const zoomed = document.createElement('div');
                              zoomed.style.position = 'fixed';
                              zoomed.style.top = '0';
                              zoomed.style.left = '0';
                              zoomed.style.width = '100%';
                              zoomed.style.height = '100%';
                              zoomed.style.backgroundColor = 'rgba(0,0,0,0.9)';
                              zoomed.style.display = 'flex';
                              zoomed.style.justifyContent = 'center';
                              zoomed.style.alignItems = 'center';
                              zoomed.style.zIndex = '2000';
                              zoomed.style.cursor = 'zoom-out';

                              const zoomedImg = document.createElement('img');
                              zoomedImg.src = this.src;
                              zoomedImg.style.maxWidth = '90%';
                              zoomedImg.style.maxHeight = '90%';
                              zoomedImg.style.objectFit = 'contain';

                              zoomed.appendChild(zoomedImg);
                              document.body.appendChild(zoomed);

                              zoomed.addEventListener('click', function() {
                                  document.body.removeChild(zoomed);
                              });
                          });
                      });
                  })
                  .catch(error => {
                      modalContent.innerHTML = '<p class="error-message">Error loading destination details</p>';
                      console.error('Error:', error);
                  });
          }

          function showNavigationMap(destinationId) {
      const mapContainer = document.getElementById('navigationMapContainer');
      const navButton = document.querySelector('#navigationMapContainer').previousElementSibling;

      // Toggle map visibility
      if (mapContainer.style.display === 'none' || mapContainer.style.display === '') {
          mapContainer.style.display = 'block';

          // 👇 Auto-scroll to map container with smooth animation
          setTimeout(() => {
              mapContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }, 200); // delay allows for smoother effect

          // Initialize map if it hasn't been already
          if (!mapContainer._map) {
              // Create map
              const map = L.map('navigationMapContainer').setView([14.0, 121.0], 10);

              // Add tile layer
              L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
              }).addTo(map);

              // Fetch destination coordinates
              fetch(`get_destination_coordinates.php?id=${destinationId}`)
                  .then(response => response.json())
                  .then(data => {
                      if (data.success && data.latitude && data.longitude) {
                          const destinationCoords = [data.latitude, data.longitude];

                          // Add destination marker
                          const destinationMarker = L.marker(destinationCoords)
                              .addTo(map)
                              .bindPopup(data.DestinationName);

                          // Try to get user's current location
                          if (navigator.geolocation) {
                              navigator.geolocation.getCurrentPosition(
                                  (position) => {
                                      const userCoords = [position.coords.latitude, position.coords.longitude];

                                      // Add user marker
                                      const userMarker = L.marker(userCoords)
                                          .addTo(map)
                                          .bindPopup('Your Location');

                                      // Add routing control
                                      L.Routing.control({
                                          waypoints: [
                                              L.latLng(userCoords[0], userCoords[1]),
                                              L.latLng(destinationCoords[0], destinationCoords[1])
                                          ],
                                          routeWhileDragging: true,
                                          showAlternatives: true,
                                          addWaypoints: false,
                                          draggableWaypoints: false,
                                          fitSelectedRoutes: true,
                                          show: true,
                                          router: L.Routing.osrmv1({
                                              serviceUrl: 'https://router.project-osrm.org/route/v1'
                                          }),
                                          lineOptions: {
                                              styles: [{ color: 'blue', opacity: 0.7, weight: 5 }]
                                          },
                                          altLineOptions: {
                                              styles: [{ color: 'gray', opacity: 0.7, weight: 3 }]
                                          }
                                      }).addTo(map);

                                      // Fit map to show both points
                                      map.fitBounds([userCoords, destinationCoords]);
                                  },
                                  (error) => {
                                      console.error('Geolocation error:', error);
                                      // Just show destination if we can't get user location
                                      map.setView(destinationCoords, 14);
                                  }
                              );
                          } else {
                              console.log('Geolocation is not supported by this browser.');
                              // Just show destination if geolocation isn't supported
                              map.setView(destinationCoords, 14);
                          }
                      }
                  })
                  .catch(error => {
                      console.error('Error fetching coordinates:', error);
                  });

              // Store map reference
              mapContainer._map = map;
          }
      } else {
          mapContainer.style.display = 'none';
      }
  }


          // Basic HTML escaping for security
          function escapeHtml(unsafe) {
              // Convert the input to a string before performing replacements.
              // This handles null, undefined, numbers, etc., gracefully.
              const s = String(unsafe);
              return s
                  .replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/"/g, "&quot;")
                  .replace(/'/g, "&#039;");
          }

          //things to do section
          //calling get destination details


  document.addEventListener('DOMContentLoaded', () => {
    let showAllActivities = false;
    let allActivities = [];

    // CHANGE THIS LINE: Use a unique ID for the Activities' "See All" button
    const seeAllActivitiesButton = document.getElementById('seeAllActivitiesBtn'); 
    const cardsContainer = document.getElementById('activitiesCards');

    function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, function (m) {
      return {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
      }[m];
    });
  }

    function renderActivities() {
      let html = '';
      const visible = showAllActivities ? allActivities : allActivities.slice(0, 3);

      visible.forEach(activity => {
        html += `
          <div class="card activity-card">
            <div class="card-image-wrapper">
              <img src="${escapeHtml(activity.ActivityImage)}" alt="${escapeHtml(activity.ActivityName)}">
              <div class="activity-overlay">
                <button class="learn-more-btn" data-activity-id="${escapeHtml(activity.ActivityID)}">View</button>
              </div>
            </div>
            <div class="card-content">
              <h3>${escapeHtml(activity.ActivityName)}</h3>
            </div>
          </div>
        `;
      });

      cardsContainer.innerHTML = html;
      initActivityModalHandlers?.();
    }

    // CHANGE THIS LINE: Attach the event listener to the correct button
    seeAllActivitiesButton?.addEventListener('click', () => { 
      showAllActivities = !showAllActivities;
      renderActivities();
      seeAllActivitiesButton.textContent = showAllActivities ? 'Show Less' : 'See All';
      setTimeout(() => {
      cardsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 300); // Delay ensures new content is rendered before scroll
    
    });

    

    function fetchActivities() {
      fetch('get_activities.php')
        .then(res => res.json())
        .then(data => {
          if (!Array.isArray(data)) {
            throw new Error('Invalid format or data missing.');
          }
          allActivities = data;
          renderActivities();
        })
        .catch(err => {
          console.error('❌ Failed to fetch activities:', err);
          if (cardsContainer) {
            cardsContainer.innerHTML = '<p class="error-message">Failed to load activities</p>';
          }
        });
    }

    fetchActivities();
  });




              function initActivityModalHandlers() {
                  const modal       = document.getElementById('activityModal');
                  const modalBody   = document.getElementById('activityModalContent');
                  const closeModal  = modal.querySelector('.close-modal');

                  document.querySelectorAll('.learn-more-btn').forEach(btn => {
                      btn.addEventListener('click', () => {
                      const id = btn.dataset.activityId;
                      modalBody.innerHTML = '<div class="loading-spinner"></div>';
                      modal.style.display = 'flex';

                      fetch(`get_activity_details.php?id=${id}`)
                          .then(r => r.json())
                          .then(d => {
                          if (!d.success) {
                              modalBody.innerHTML = `<p class="error-message">${d.message}</p>`;
                              return;
                          }

                          const destList = d.Destinations.length
                                              ? `<div class="destination-badges">
                                                      ${d.Destinations.map(x => `
                          <a span="resort.php?id=${x.DestinationID}" class="destination-badge">
                              ${escapeHtml(x.DestinationName)}
                          </a>
                          `).join('')}
                                  </div>`
                              : '<p>No destinations offer this activity yet.</p>';


                          modalBody.innerHTML = `
                              <h2 class="modal-title">${escapeHtml(d.ActivityName)}</h2>
                              <img src="${d.ActivityImage}"
                                  alt="${escapeHtml(d.ActivityName)}"
                                  class="modal-activity-img">
                              ${destList}`;
                          })
                          .catch(err => {
                          modalBody.innerHTML = '<p class="error-message">Error loading details.</p>';
                          console.error(err);
                          });
                      });
                  });

                  closeModal.addEventListener('click', () => modal.style.display = 'none');
                  modal.addEventListener('click', e => { if (e.target === modal) modal.style.display = 'none'; });
                  }


  document.addEventListener('DOMContentLoaded', () => {
    let showAllNews = false;
    let allNews = [];

    const seeAllNewsButton = document.getElementById('seeAllNewsBtn');
    const newsCardsContainer = document.getElementById('newsCards');

    function escapeHtml(str) {
      return String(str).replace(/[&<>"']/g, function (m) {
        return {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#39;'
        }[m];
      });
    }

    function renderNews() {
      if (!newsCardsContainer) {
        console.error('News cards container not found.');
        return;
      }

      if (!Array.isArray(allNews) || allNews.length === 0) {
        newsCardsContainer.innerHTML = '<p class="info-message">No news available at the moment.</p>';
        return;
      }

      const visibleNews = showAllNews ? allNews : allNews.slice(0, 3);
      let html = '';

      visibleNews.forEach(newsItem => {
        html += `
          <div class="card news-card">
            <img src="${escapeHtml(newsItem.NewsImage)}" alt="${escapeHtml(newsItem.NewsTitle)}">
            <div class="card-content">
              <h3>${escapeHtml(newsItem.NewsTitle)}</h3>
              <p>${escapeHtml(newsItem.NewsHeadline)}</p>
              <button class="read-more-btn" data-news-id="${escapeHtml(newsItem.NewsID)}">Read More</button>
            </div>
          </div>
        `;
      });

      newsCardsContainer.innerHTML = html;
      initNewsModal?.();
    }

    seeAllNewsButton?.addEventListener('click', () => {
      showAllNews = !showAllNews;
      renderNews();
      seeAllNewsButton.textContent = showAllNews ? 'Show Less' : 'See All';
      setTimeout(() => {
      cardsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 300);
    });

    function fetchNews() {
      fetch('get_news.php')
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          if (!data.success || !Array.isArray(data.data)) {
            throw new Error('Invalid data format received from get_news.php');
          }
          allNews = data.data;
          renderNews();
        })
        .catch(error => {
          console.error('❌ Failed to fetch news:', error);
          if (newsCardsContainer) {
            newsCardsContainer.innerHTML = `<p class="error-message">Failed to load news: ${error.message}. Please try again later.</p>`;
          }
        });
    }

    fetchNews();
  });


  function initNewsModal() {
      const modal = document.getElementById('exploreModal');
      const modalBody = document.getElementById('modalContent');

      document.querySelectorAll('.read-more-btn').forEach(btn => {
          btn.addEventListener('click', () => {
              const id = btn.dataset.newsId;
              modalBody.innerHTML = '<div class="loading-spinner"></div>';
              modal.style.display = 'flex';

              fetch(`get_news_details.php?id=${id}`)
                  .then(r => r.json())
                  .then(d => {
                      if (!d.success) {
                          modalBody.innerHTML = `<p class="error-message">${d.message}</p>`;
                          return;
                      }
                      modalBody.innerHTML = `
                          <h2 class="modalnews-title">${d.NewsTitle}</h2>
                          <img src="${d.NewsImage}" alt="${d.NewsTitle}" class="news-image">
                          <p class="modalnews-description">${d.NewsBody}</p>
                          <p style="text-align:right;font-size:.9rem;color:#7f8c8d;">
                              ${new Date(d.NewsDate).toLocaleString()}
                          </p>
                      `;
                  })
                  .catch(() => {
                      modalBody.innerHTML = '<p class="error-message">Error loading news.</p>';
                  });
          });
      });
  }
    





