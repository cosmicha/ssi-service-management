
<div class="spa-view">
    
    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">HP</span>
                        HELP CENTER
                    </div>
                    <h1>Incident Portal Ticketing System Help Center</h1>
                    <p>
                        This guide covers the latest capabilities of the platform, including incident reporting,
                        engineer workflow, progress timeline, SLA tracking in hours, email notifications,
                        analytics, executive dashboards, and operational administration.
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                    <a href="/analytics" class="btn btn-primary">Open Analytics</a>
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <div class="section-title">Create and Track Tickets</div>
                <div class="muted">Customers and users can submit incidents and monitor progress end to end.</div>

                <div class="item">
                    <h3>How to create a ticket</h3>
                    <ul>
                        <li>Click <strong>Add New Log</strong></li>
                        <li>Fill title, description, and priority</li>
                        <li>Upload a supporting photo if available</li>
                        <li>Submit the ticket</li>
                    </ul>
                </div>

                <div class="item">
                    <h3>What users can monitor</h3>
                    <ul>
                        <li>Ticket number and title</li>
                        <li>Status and assigned engineer</li>
                        <li>Response SLA and resolution SLA</li>
                        <li>Timeline updates and closure notes</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Ticket Status Lifecycle</div>
                <div class="muted">Tickets follow a structured lifecycle from creation until completion.</div>

                <div class="pill-row">
                    <div class="pill status-open">Open</div>
                    <div class="pill status-progress">In Progress</div>
                    <div class="pill status-closed">Closed</div>
                </div>

                <div class="item" style="margin-top:14px;">
                    <h3>Status meaning</h3>
                    <ul>
                        <li><strong>Open</strong> → newly created and waiting for action</li>
                        <li><strong>In Progress</strong> → acknowledged and actively handled</li>
                        <li><strong>Closed</strong> → resolved and completed</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Engineer Workflow</div>
                <div class="muted">Engineers can take ownership of tickets and maintain handling visibility.</div>

                <div class="item">
                    <h3>Main actions</h3>
                    <ul>
                        <li>Take Ticket</li>
                        <li>Acknowledge ticket</li>
                        <li>Add progress updates</li>
                        <li>Upload closing evidence if required</li>
                        <li>Close ticket after issue is resolved</li>
                    </ul>
                </div>

                <div class="item">
                    <h3>Progress timeline</h3>
                    <p>
                        Every important action can be logged as a progress update, such as onsite checking,
                        waiting for spare parts, temporary fix, retesting, or final resolution.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="section-title">SLA Settings in Hours</div>
                <div class="muted">Each company can configure SLA targets using hours, not minutes.</div>

                <div class="item">
                    <h3>Response Time</h3>
                    <p>Maximum time allowed for first acknowledgement or start of handling since ticket creation.</p>
                </div>

                <div class="item">
                    <h3>Resolution Time</h3>
                    <p>Maximum time allowed until the ticket is fully resolved and closed.</p>
                </div>

                <div class="item">
                    <h3>SLA status</h3>
                    <ul>
                        <li><strong>On Time</strong> → still within target</li>
                        <li><strong>Breached</strong> → exceeded target</li>
                        <li><strong>N/A</strong> → SLA not active or not yet applicable</li>
                    </ul>
                </div>
            </div>

            <div class="card full">
                <div class="section-title">Email Notifications</div>
                <div class="muted">Automatic email notifications can be sent to keep all stakeholders informed.</div>

                <div class="mini-grid">
                    <div class="mini-box">
                        <h4>Events</h4>
                        <p>Ticket created, assigned, acknowledged, progress updated, and closed.</p>
                    </div>
                    <div class="mini-box">
                        <h4>Recipients</h4>
                        <p>Company notification emails, ticket creator, assigned engineer, and administrators.</p>
                    </div>
                    <div class="mini-box">
                        <h4>Delivery</h4>
                        <p>Emails are processed through background queue workers for stable delivery.</p>
                    </div>
                </div>
            </div>

            <div class="card full">
                <div class="section-title">Analytics Dashboard</div>
                <div class="muted">The system includes analytics and executive operational insights.</div>

                <div class="mini-grid">
                    <div class="mini-box">
                        <h4>Core KPI</h4>
                        <p>Total tickets, open, in progress, closed, closure rate, average response time, and average resolution time.</p>
                    </div>
                    <div class="mini-box">
                        <h4>SLA Insight</h4>
                        <p>Response breach count, resolution breach count, overdue now, and aging buckets.</p>
                    </div>
                    <div class="mini-box">
                        <h4>Operational Load</h4>
                        <p>Tickets by company, tickets by engineer, top breached companies, and top loaded engineers.</p>
                    </div>
                </div>

                <div class="item" style="margin-top:14px;">
                    <h3>Executive analytics features</h3>
                    <ul>
                        <li>Monthly ticket trend</li>
                        <li>Monthly closure trend</li>
                        <li>Monthly SLA breach trend</li>
                        <li>Most critical tickets</li>
                        <li>Top issue categories inferred from ticket titles</li>
                        <li>Executive summary cards</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Administrator Capabilities</div>
                <div class="muted">Admins have full operational and configuration access.</div>

                <div class="item">
                    <h3>Admin can manage</h3>
                    <ul>
                        <li>Users and approval status</li>
                        <li>Roles and password reset</li>
                        <li>Companies and SLA settings</li>
                        <li>Notification email list per company</li>
                        <li>Engineer assignment</li>
                        <li>Export data and view analytics</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="section-title">Filtering and Reporting</div>
                <div class="muted">The main dashboard supports search and operational filtering.</div>

                <div class="item">
                    <h3>Available filters</h3>
                    <ul>
                        <li>Keyword search</li>
                        <li>Status</li>
                        <li>Priority</li>
                        <li>Company</li>
                        <li>Engineer</li>
                        <li>Response SLA status</li>
                        <li>Resolution SLA status</li>
                        <li>Date range</li>
                    </ul>
                </div>

                <div class="item">
                    <h3>Export</h3>
                    <p>Ticket data can be exported for operational review and management reporting.</p>
                </div>
            </div>

            <div class="card full">
                <div class="section-title">Best Practice</div>
                <div class="muted">Recommended usage to keep incident handling efficient and auditable.</div>

                <div class="mini-grid">
                    <div class="mini-box">
                        <h4>For Users</h4>
                        <p>Submit clear ticket titles, complete descriptions, and supporting photos whenever possible.</p>
                    </div>
                    <div class="mini-box">
                        <h4>For Engineers</h4>
                        <p>Acknowledge quickly, add timeline updates for non-instant work, and close only after resolution is confirmed.</p>
                    </div>
                    <div class="mini-box">
                        <h4>For Admins</h4>
                        <p>Monitor overdue tickets, review analytics regularly, and keep company SLA settings aligned with contract commitments.</p>
                    </div>
                </div>
            </div>

            <div class="card full">
                <div class="section-title">Need More Assistance?</div>
                <div class="muted">For help regarding account access, registration approval, SLA setup, or notification issues, contact support.</div>

                <div class="item">
                    <h3>Support Contact</h3>
                    <p><strong>Email:</strong> support@x1eventflow.com</p>
                </div>
            </div>
        </div>
    </div>

</div>
