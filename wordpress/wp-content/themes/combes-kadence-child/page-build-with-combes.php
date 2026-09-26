<?php
/**
 * Template Name: Build With Combes
 * Description: Premium multi-step project inquiry wizard stored as Project Inquiries.
 */

get_header();
?>

<main id="primary" class="site-main page-build-with-combes">

    <!-- Hero -->
    <section class="section section--dark hero-slideshow" data-aos="fade-up">
        <div class="section__inner hero-slideshow__content">
            <p class="hero-slideshow__eyebrow animate-fade-up">
                BUILD WITH COMBES
            </p>

            <h1 class="hero-slideshow__headline animate-fade-up animate-delay-1">
                Let’s Build Something Together.
            </h1>

            <p class="hero-slideshow__subline animate-fade-up animate-delay-2">
                Share your project vision, constraints, and timing. Combes will partner with you from early
                planning through turnover to align architecture, budget, and schedule.
            </p>

            <div class="wp-block-buttons hero-slideshow__actions animate-fade-up animate-delay-3">
                <div class="wp-block-button is-style-fill">
                    <a class="wp-block-button__link" href="#build-with-combes-wizard">
                        Start Project Builder
                    </a>
                </div>
                <div class="wp-block-button is-style-outline button--ghost">
                    <a class="wp-block-button__link button--ghost" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
                        Talk with Our Team
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Wizard container -->
    <section id="build-with-combes-wizard" class="section section--surface" data-aos="fade-up">
    <div class="section__inner">
        <?php if ( isset( $_GET['build_submitted'] ) && '1' === $_GET['build_submitted'] ) : ?>
            <div class="combes-card animate-fade-up" style="margin-bottom: 2rem;">
                <h2>Thank you for reaching out.</h2>
                <p>
                    Your project inquiry has been received. Combes will review your information and follow up
                    personally to discuss feasibility, schedule, budget, and next steps.
                </p>
            </div>
        <?php elseif ( isset( $_GET['build_error'] ) ) : ?>
            <div class="combes-card animate-fade-up" style="margin-bottom: 2rem; border-color: #f87171;">
                <h2>There was an issue submitting your inquiry.</h2>
                <p>Please try again. If the problem continues, contact us directly.</p>
            </div>
        <?php endif; ?>


            <div class="build-wizard">

                <!-- Progress bar -->
                <div class="build-progress">
                    <div class="build-progress__labels">
                        <span>Contact</span>
                        <span>Details</span>
                        <span>Services</span>
                        <span>Budget</span>
                        <span>Schedule</span>
                        <span>Description</span>
                        <span>Documents</span>
                        <span>Review</span>
                    </div>
                    <div class="build-progress__bar">
                        <div class="build-progress__bar-fill"></div>
                    </div>
                </div>

                <form id="build-with-combes-form"
                        class="build-wizard__form"
                        action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
                        method="post"
                        enctype="multipart/form-data">


                    <?php wp_nonce_field( 'combes_build_with_combes', 'combes_build_nonce' ); ?>
                    <input type="hidden" name="action" value="combes_build_with_combes_submit">


                    <!-- STEP 1: Contact Information -->
                    <section class="build-step is-active" data-step="1">
                        <div class="build-step__inner">
                            <header class="build-step__header">
                                <p class="build-step__eyebrow">Step 1</p>
                                <h2>Who should we contact?</h2>
                                <p>Combes will follow up personally using the information below.</p>
                            </header>

                            <div class="build-step__content">
                                <div class="build-field-row">
                                    <div class="build-field">
                                        <label for="bw_name">Your name</label>
                                        <input type="text" id="bw_name" name="bw_name" required>
                                    </div>
                                    <div class="build-field">
                                        <label for="bw_company">Company / organization</label>
                                        <input type="text" id="bw_company" name="bw_company">
                                    </div>
                                </div>

                                <div class="build-field-row">
                                    <div class="build-field">
                                        <label for="bw_email">Email</label>
                                        <input type="email" id="bw_email" name="bw_email" required>
                                    </div>
                                    <div class="build-field">
                                        <label for="bw_phone">Phone</label>
                                        <input type="tel" id="bw_phone" name="bw_phone">
                                    </div>
                                </div>
                            </div>

                            <div class="build-step__footer">
                                <button type="button" class="button kt-button" data-role="next">Next: Project Details</button>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 2: Project Details -->
                    <section class="build-step" data-step="2">
                        <div class="build-step__inner">
                            <header class="build-step__header">
                                <p class="build-step__eyebrow">Step 2</p>
                                <h2>Tell us about your project</h2>
                                <p>Choose the type of work you’re planning and where it will be built.</p>
                            </header>

                            <div class="build-step__content">
                                <h3>Project type</h3>
                                <div class="build-card-grid" data-group="project_type">
                                    <?php
                                    $types = array(
                                        'Commercial',
                                        'Education',
                                        'Municipal',
                                        'Industrial',
                                        'Healthcare',
                                        'Religious',
                                        'Other',
                                    );
                                    foreach ( $types as $type ) :
                                        ?>
                                        <button type="button"
                                                class="build-card build-card--select"
                                                data-group="project_type"
                                                data-value="<?php echo esc_attr( $type ); ?>">
                                            <h3><?php echo esc_html( $type ); ?></h3>
                                            <p>Representative new construction, additions, and renovations.</p>
                                        </button>
                                        <?php
                                    endforeach;
                                    ?>
                                </div>
                                <input type="hidden" name="bw_project_type" id="bw_project_type" required>

                                <div class="build-field-row">
                                    <div class="build-field">
                                        <label for="bw_project_name">Project name</label>
                                        <input type="text" id="bw_project_name" name="bw_project_name" required>
                                    </div>
                                    <div class="build-field">
                                        <label for="bw_location">Project location</label>
                                        <input type="text" id="bw_location" name="bw_location" required
                                               placeholder="City, state, campus, or facility">
                                    </div>
                                </div>
                            </div>

                            <div class="build-step__footer">
                                <button type="button" class="button button--ghost" data-role="back">Back</button>
                                <button type="button" class="button kt-button" data-role="next">Next: Services</button>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 3: Services Requested -->
                    <section class="build-step" data-step="3">
                        <div class="build-step__inner">
                            <header class="build-step__header">
                                <p class="build-step__eyebrow">Step 3</p>
                                <h2>Services you’re considering</h2>
                                <p>Select the delivery approach or support you’d like to discuss.</p>
                            </header>

                            <div class="build-step__content">
                                <div class="build-card-grid" data-group="services">
                                    <?php
                                    $services_cards = array(
                                        'General Contracting',
                                        'Construction Management',
                                        'Design-Build',
                                        'Preconstruction & Budgeting',
                                        'GMP / Negotiated Work',
                                        'Not sure yet',
                                    );
                                    foreach ( $services_cards as $svc ) :
                                        ?>
                                        <button type="button"
                                                class="build-card build-card--select"
                                                data-group="services"
                                                data-value="<?php echo esc_attr( $svc ); ?>">
                                            <h3><?php echo esc_html( $svc ); ?></h3>
                                            <p>Click to indicate your preferred starting point.</p>
                                        </button>
                                        <?php
                                    endforeach;
                                    ?>
                                </div>
                                <input type="hidden" name="bw_services" id="bw_services" required>
                            </div>

                            <div class="build-step__footer">
                                <button type="button" class="button button--ghost" data-role="back">Back</button>
                                <button type="button" class="button kt-button" data-role="next">Next: Budget</button>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 4: Budget Range -->
                    <section class="build-step" data-step="4">
                        <div class="build-step__inner">
                            <header class="build-step__header">
                                <p class="build-step__eyebrow">Step 4</p>
                                <h2>Budget range</h2>
                                <p>Select the approximate construction value for the project.</p>
                            </header>

                            <div class="build-step__content">
                                <div class="build-card-grid" data-group="budget">
                                    <?php
                                    $budget_ranges = array(
                                        '$0–$1M',
                                        '$1M–$5M',
                                        '$5M–$10M',
                                        '$10M–$25M',
                                        '$25M+',
                                        'Not sure yet',
                                    );
                                    foreach ( $budget_ranges as $range ) :
                                        ?>
                                        <button type="button"
                                                class="build-card build-card--select"
                                                data-group="budget"
                                                data-value="<?php echo esc_attr( $range ); ?>">
                                            <h3><?php echo esc_html( $range ); ?></h3>
                                        </button>
                                        <?php
                                    endforeach;
                                    ?>
                                </div>
                                <input type="hidden" name="bw_budget_range" id="bw_budget_range" required>
                            </div>

                            <div class="build-step__footer">
                                <button type="button" class="button button--ghost" data-role="back">Back</button>
                                <button type="button" class="button kt-button" data-role="next">Next: Schedule</button>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 5: Schedule -->
                    <section class="build-step" data-step="5">
                        <div class="build-step__inner">
                            <header class="build-step__header">
                                <p class="build-step__eyebrow">Step 5</p>
                                <h2>Schedule considerations</h2>
                                <p>Share your timing expectations and any schedule drivers.</p>
                            </header>

                            <div class="build-step__content">
                                <div class="build-card-grid build-card-grid--timeline" data-group="timeline">
                                    <?php
                                    $timelines = array(
                                        'Within 6 months',
                                        '6–12 months',
                                        '12–24 months',
                                        '24+ months',
                                        'Flexible / TBD',
                                    );
                                    foreach ( $timelines as $timeline ) :
                                        ?>
                                        <button type="button"
                                                class="build-card build-card--select"
                                                data-group="timeline"
                                                data-value="<?php echo esc_attr( $timeline ); ?>">
                                            <h3><?php echo esc_html( $timeline ); ?></h3>
                                        </button>
                                        <?php
                                    endforeach;
                                    ?>
                                </div>
                                <input type="hidden" name="bw_timeline" id="bw_timeline" required>

                                <div class="build-field">
                                    <label for="bw_start_date">Preferred start date (optional)</label>
                                    <input type="text" id="bw_start_date" name="bw_start_date"
                                           placeholder="Month / year or specific date">
                                </div>
                            </div>

                            <div class="build-step__footer">
                                <button type="button" class="button button--ghost" data-role="back">Back</button>
                                <button type="button" class="button kt-button" data-role="next">Next: Description</button>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 6: Project Description -->
                    <section class="build-step" data-step="6">
                        <div class="build-step__inner">
                            <header class="build-step__header">
                                <p class="build-step__eyebrow">Step 6</p>
                                <h2>Describe the project</h2>
                                <p>Share major program elements, phasing, schedule drivers, and constraints.</p>
                            </header>

                            <div class="build-step__content">
                                <div class="build-field">
                                    <label for="bw_description">Project description</label>
                                    <textarea id="bw_description" name="bw_description" rows="5" required
                                              placeholder="Facility type, major uses, phasing, schedule drivers, and any key constraints."></textarea>
                                </div>
                            </div>

                            <div class="build-step__footer">
                                <button type="button" class="button button--ghost" data-role="back">Back</button>
                                <button type="button" class="button kt-button" data-role="next">Next: Documents</button>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 7: Supporting Documents -->
                    <section class="build-step" data-step="7">
                        <div class="build-step__inner">
                            <header class="build-step__header">
                                <p class="build-step__eyebrow">Step 7</p>
                                <h2>Supporting documents</h2>
                                <p>Upload any drawings, renderings, specifications, RFPs, or other project files.</p>
                            </header>

                            <div class="build-step__content">
                                <div class="build-field">
                                    <label for="bw_documents">Project documents (optional)</label>
                                    <input type="file" id="bw_documents" name="bw_documents[]" multiple
                                           accept=".pdf,.dwg,.dxf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.tif,.tiff">
                                    <p class="build-field__hint">
                                        You can attach plans, renderings, specifications, RFPs, photos, and other supporting documents.
                                    </p>
                                </div>
                            </div>

                            <div class="build-step__footer">
                                <button type="button" class="button button--ghost" data-role="back">Back</button>
                                <button type="button" class="button kt-button" data-role="next">Review</button>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 8: Review & submit -->
                    <section class="build-step" data-step="8">
                        <div class="build-step__inner">
                            <header class="build-step__header">
                                <p class="build-step__eyebrow">Step 8</p>
                                <h2>Review your project</h2>
                                <p>Confirm the details below, then submit to start the conversation.</p>
                            </header>

                            <div class="build-step__content build-review">
                                <div class="build-review__column">
                                    <h3>Contact</h3>
                                    <ul>
                                        <li><strong>Name:</strong> <span data-review="bw_name"></span></li>
                                        <li><strong>Company:</strong> <span data-review="bw_company"></span></li>
                                        <li><strong>Email:</strong> <span data-review="bw_email"></span></li>
                                        <li><strong>Phone:</strong> <span data-review="bw_phone"></span></li>
                                    </ul>

                                    <h3>Project</h3>
                                    <ul>
                                        <li><strong>Type:</strong> <span data-review="bw_project_type"></span></li>
                                        <li><strong>Name:</strong> <span data-review="bw_project_name"></span></li>
                                        <li><strong>Location:</strong> <span data-review="bw_location"></span></li>
                                    </ul>
                                </div>

                                <div class="build-review__column">
                                    <h3>Delivery & Size</h3>
                                    <ul>
                                        <li><strong>Services:</strong> <span data-review="bw_services"></span></li>
                                        <li><strong>Budget range:</strong> <span data-review="bw_budget_range"></span></li>
                                        <li><strong>Timeline:</strong> <span data-review="bw_timeline"></span></li>
                                        <li><strong>Preferred start date:</strong> <span data-review="bw_start_date"></span></li>
                                    </ul>

                                    <h3>Description</h3>
                                    <ul>
                                        <li><strong>Summary:</strong> <span data-review="bw_description"></span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="build-step__footer">
                                <button type="button" class="button button--ghost" data-role="back">Back</button>
                                <button type="submit" class="button kt-button">
                                    Submit Project Inquiry
                                </button>
                            </div>
                        </div>
                    </section>

                </form>

                <p class="build-trust-copy">
                    Combes will review your submission and follow up personally to discuss feasibility, schedule,
                    budget, delivery method, and next steps. This is the beginning of a conversation — not a commitment.
                </p>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
