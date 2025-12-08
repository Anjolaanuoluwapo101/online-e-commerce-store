<div class="position-relative">
    <!-- Hero Banner for Contact Page -->
    <div class="contact-hero position-relative text-white text-center py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('/assets/images/slide_03.jpg') center/cover no-repeat; min-height: 400px; display: flex; align-items: center;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown" style="color: rgba(255, 255, 255, 1);">Get In Touch</h1>
                    <p class="lead fs-4 animate__animated animate__fadeInUp" style="color: rgba(255, 255, 255, 0.7);">We'd love to hear from you. Reach out to us anytime!</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container py-5 position-relative" style="margin-top: -50px; z-index: 10;">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white rounded-pill px-4 py-3 shadow-sm">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-pill px-4 py-3 shadow-sm" role="alert">
                <i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row mb-5 fade-in-element" style="opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out;">
            <div class="col-12">
                <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-7">
                                <div class="p-4 p-lg-5">
                                    <h2 class="display-5 fw-bold mb-4 text-danger">Send us a Message</h2>
                                    
                                    <!-- Success Message -->
                                    <div id="success-message" class="alert alert-success d-none rounded-pill px-4 py-3" role="alert">
                                        <i class="fa fa-check-circle me-2"></i>Thank you for contacting us. We will get back to you soon.
                                    </div>
                                    
                                    <!-- Error Message -->
                                    <div id="error-message" class="alert alert-danger d-none rounded-pill px-4 py-3" role="alert">
                                        <i class="fa fa-exclamation-triangle me-2"></i>Sorry, there was an error sending your message. Please try again later.
                                    </div>
                                    
                                    <div class="contact-form">
                                        <form id="contact" action="/contact/submit" method="post">
                                            <div class="mb-4">
                                                <label for="name" class="form-label fw-bold">Full Name</label>
                                                <input name="name" type="text" class="form-control form-control-lg rounded-pill px-4 py-3" id="name" placeholder="Enter your full name" required>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label for="email" class="form-label fw-bold">Email Address</label>
                                                <input name="email" type="email" class="form-control form-control-lg rounded-pill px-4 py-3" id="email" placeholder="Enter your email address" required>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label for="subject" class="form-label fw-bold">Subject</label>
                                                <input name="subject" type="text" class="form-control form-control-lg rounded-pill px-4 py-3" id="subject" placeholder="Enter subject" required>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label for="address" class="form-label fw-bold">Address</label>
                                                <textarea name="address" rows="3" class="form-control rounded-3 px-4 py-3" id="address" placeholder="Enter your address"></textarea>
                                            </div>
                                            
                                            <div class="mb-5">
                                                <label for="message" class="form-label fw-bold">Message</label>
                                                <textarea name="message" rows="6" class="form-control rounded-3 px-4 py-3" id="message" placeholder="Enter your message" required></textarea>
                                            </div>
                                            
                                            <button type="submit" id="form-submit" class="btn btn-danger btn-lg w-100 rounded-pill px-4 py-3 hover-lift">
                                                <span id="button-text">Send Message</span>
                                                <span id="button-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-5 bg-light d-flex flex-column justify-content-center p-4 p-lg-5 fade-in-element" style="opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out;">
                                <h3 class="mb-4">Contact Information</h3>
                                
                                <div class="d-flex mb-4 hover-lift">
                                    <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0; border: 2px solid #dc3545;">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Our Location</h5>
                                        <p class="mb-0 text-muted">123 Main Street, Lagos, Nigeria</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-4 hover-lift">
                                    <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0; border: 2px solid #dc3545;">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Phone Number</h5>
                                        <p class="mb-0 text-muted">+234 801 234 5678</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-4 hover-lift">
                                    <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0; border: 2px solid #dc3545;">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Email Address</h5>
                                        <p class="mb-0 text-muted">info@shopconv.com</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-4 hover-lift">
                                    <div class="icon-wrapper text-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; flex-shrink: 0; border: 2px solid #dc3545;">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Working Hours</h5>
                                        <p class="mb-0 text-muted">Mon-Fri: 9AM - 6PM<br>Sat-Sun: 10AM - 4PM</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <h5 class="mb-3">Follow Us</h5>
                                    <div class="d-flex gap-3">
                                        <a href="#" class="btn btn-outline-danger rounded-circle" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-facebook-f"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger rounded-circle" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger rounded-circle" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger rounded-circle" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-5 fade-in-element" style="opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out;">
            <div class="col-12">
                <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                    <div class="card-header bg-dark text-white py-4 text-center">
                        <h3 class="mb-0">Find Us on the Map</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="ratio ratio-21x9">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.959575215783!2d3.3754303147707!3d6.527043595270791!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8b2ae68280c1%3A0xdc9e87a367c3d9cb!2sLagos%2C%20Nigeria!5e0!3m2!1sen!2sng!4v1650000000000!5m2!1sen!2sng" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 992px) {
    .contact-hero {
        min-height: 300px;
    }
    
    .display-3 {
        font-size: 2rem;
    }
    
    .display-5 {
        font-size: 1.75rem;
    }
    
    .p-5 {
        padding: 1.5rem !important;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .rounded-3 {
        border-radius: 1rem !important;
    }
    
    .shadow-lg {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.075) !important;
    }
}

@media (max-width: 768px) {
    .g-0 {
        --bs-gutter-x: 1rem;
    }
    
    .p-5 {
        padding: 1rem !important;
    }
    
    .form-control-lg {
        padding: 0.75rem 1rem !important;
    }
    
    .btn-lg {
        padding: 0.75rem 1rem !important;
    }
}

.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.fade-in-element {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact');
    const submitButton = document.getElementById('form-submit');
    const buttonText = document.getElementById('button-text');
    const buttonSpinner = document.getElementById('button-spinner');
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Hide previous messages
        successMessage.classList.add('d-none');
        errorMessage.classList.add('d-none');
        
        // Get form data
        const formData = new FormData(contactForm);
        
        // Show loading state
        buttonText.textContent = 'Sending...';
        buttonSpinner.classList.remove('d-none');
        submitButton.disabled = true;
        
        // Send AJAX request
        fetch('/contact/submit', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Reset button state
            buttonText.textContent = 'Send Message';
            buttonSpinner.classList.add('d-none');
            submitButton.disabled = false;
            
            if (data.success) {
                // Show success message
                successMessage.classList.remove('d-none');
                // Reset form
                contactForm.reset();
            } else {
                // Show error message
                errorMessage.textContent = data.message || 'Sorry, there was an error sending your message. Please try again later.';
                errorMessage.classList.remove('d-none');
            }
        })
        .catch(error => {
            // Reset button state
            buttonText.textContent = 'Send Message';
            buttonSpinner.classList.add('d-none');
            submitButton.disabled = false;
            
            // Show error message
            errorMessage.textContent = 'Sorry, there was an error sending your message. Please try again later.';
            errorMessage.classList.remove('d-none');
        });
    });
});

// Fade in elements when they come into view
function checkFadeElements() {
    const fadeElements = document.querySelectorAll('.fade-in-element');
    fadeElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < window.innerHeight - elementVisible) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
}

// Check on scroll and initial load
window.addEventListener('scroll', checkFadeElements);
window.addEventListener('load', checkFadeElements);

// Initial check in case element is already in view
setTimeout(checkFadeElements, 100);
</script>