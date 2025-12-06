<div class="container py-4 fade-in">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row mb-4 slide-up">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white py-4">
                    <h1 class="mb-0 text-center">Get In Touch With Us</h1>
                </div>
                <div class="card-body py-4">
                    <div class="row">
                        <div class="mt-4 col-lg-8">
                            <h3 class="mb-4">Send us a Message</h3>
                            <!-- Success Message -->
                            <div id="success-message" class="alert alert-success d-none" role="alert">
                                Thank you for contacting us. We will get back to you soon.
                            </div>
                            
                            <!-- Error Message -->
                            <div id="error-message" class="alert alert-danger d-none" role="alert">
                                Sorry, there was an error sending your message. Please try again later.
                            </div>
                            
                            <div class="contact-form">
                                <form id="contact" action="/contact/submit" method="post">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input name="name" type="text" class="form-control" id="name" placeholder="Enter your full name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input name="email" type="email" class="form-control" id="email" placeholder="Enter your email address" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input name="subject" type="text" class="form-control" id="subject" placeholder="Enter subject" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea name="message" rows="6" class="form-control" id="message" placeholder="Enter your message" required></textarea>
                                    </div>
                                    
                                    <button type="submit" id="form-submit" class="btn btn-danger btn-lg px-4 py-2">
                                        <span id="button-text">Send Message</span>
                                        <span id="button-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- A divider that only shows up on small screen  -->
                        <hr class="d-lg-none my-4">
                        <hr class="d-block d-md-none border-top border-primary my-4">
                        <div class="mt-4 col-lg-4">
                            <h3 class="mb-4">Our Information</h3>
                            <div class="card mb-4 shadow-sm hover-lift">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-map-marker text-danger me-2"></i> Our Location</h5>
                                    <p class="card-text">123 Main Street, Lagos, Nigeria</p>
                                </div>
                            </div>
                            
                            <div class="card mb-4 shadow-sm hover-lift">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-phone text-danger me-2"></i> Phone Number</h5>
                                    <p class="card-text">+234 801 234 5678</p>
                                </div>
                            </div>
                            
                            <div class="card mb-4 shadow-sm hover-lift">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fa fa-envelope text-danger me-2"></i> Email Address</h5>
                                    <p class="card-text">info@shopconv.com</p>
                                </div>
                            </div>
                            
                            <!-- <div class="text-center mt-4">
                                <img src="/assets/images/send-message.jpg" class="img-fluid rounded shadow hover-zoom" alt="Send Message" style="max-height: 200px;">
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <div class="row slide-up">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-light py-3">
                    <h3 class="mb-0 text-center">Find Us on the Map</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                             <div id="map" class="text-center">
                                <img src="/assets/images/map.jpg" alt="Map" class="img-fluid rounded shadow hover-zoom" style="max-height: 400px;">
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>

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
</script>