## Customer support

<p>A system to manage support tickets. customers register as users and can create tickets, then admins assign them to agents, and all parties can View ticket statuses.</p>

1. **User Registration:** The first step in any customer support system is to allow customers to register as users. This could involve creating an account with their name, email address, and other relevant details.

2. **Ticket Creation:** Once registered, customers should be able to create support tickets when they encounter an issue or have a question. This may involve filling out a form that includes a description of the issue, relevant details, and any attachments or screenshots that could help diagnose the problem.

3. **Ticket Management:** Once a support ticket is created, it needs to be managed effectively. This includes assigning the ticket to an available agent who has the necessary skills to handle the issue. The ticket management system should allow for tracking and updating the ticket status, as well as assigning a priority level to it based on its urgency.

4. **Agent Assignment:** An administrator should be able to assign a support ticket to an available agent, who will then take ownership of the ticket and begin working on a resolution. This may involve additional communication with the customer, further investigation, or collaboration with other agents.

5. **Ticket Status Updates:** As the support ticket progresses, it should be updated with relevant information and status updates. This could include notes on what steps have been taken, any additional information that has been gathered, or changes in the priority level or status of the ticket.

## The system should have 3 types of users

1. **Standard users** (the ones who will make tickets)

2. **Administrator** (the ones who will be assigning tickets to the agents)

3. **Agents** (the ones who will be replying to the tickets)

## Setup (DDEV)

1. `ddev config`
2. `copy .env.example into .env`
3. `ddev start`
4. `ddev composer install`
5. `ddev php artisan migrate --seed`
6. `npm install`
7. `npm run dev`

## Users

**Admin user:**

```
"email": "admin@admin.com",
"password": "Password123"
```

**Agent user:**

```
"email": "agent@agent.com",
"password": "Password123"
```

**Standard user:**

```
"email": "customer@customer.com",
"password": "Password123"
```
