
# Mawater - Water Meter Management and Billing System

## 📋 Table of Contents
1. [Project Overview](#1-project-overview)
2. [Business Problem](#2-business-problem)
3. [Project Scope](#3-project-scope)
4. [Actors](#4-actors--user-types)
5. [Features](#5-main-features)
6. [User Stories](#6-user-stories)
7. [Product Backlog](#7-initial-product-backlog)

---

## 1. Project Overview

### 1.1 Project Name
**"Mawater"** : Computer system for water meter management and billing.

### 1.2 General Context
Within the local association responsible for drinking water distribution in the village, meter management, consumption readings, repairs, and billing are currently carried out manually using paper registers.

This traditional method has several limitations:
- Slow processing
- Difficulty tracking payments
- Lack of repair traceability
- Lack of visibility on financial losses
- Unformalized task distribution among association members

### 1.3 Target Audience
- **Local water management** association
- **Association administrators**
- **Meter repair manager**
- **Payment collection agent**
- **Village residents** (indirect beneficiaries)

### 1.4 Overall Objective
The objective of this project is to design and develop a web application to:
- ✅ Digitize water meter management
- ✅ Automate monthly billing
- ✅ Structure payment tracking
- ✅ Track repairs and financial losses
- ✅ Clarify responsibilities of each stakeholder
- ✅ Improve financial and organizational transparency

---

## 2. Business Problem

The current manual management system presents several difficulties:

| Problem | Impact |
|----------|--------|
| Frequent calculation errors | Inaccurate invoices |
| Delays in monthly billing | Disorganized cash flow |
| Lack of payment tracking | Unidentified unpaid bills |
| No clear repair history | Inefficient maintenance |
| Difficulty assessing losses | Poor financial management |
| Risk of document loss | Critical data loss |

These problems directly impact beneficiary trust and the association's sound financial management.

---

## 3. Project Scope

### 3.1 What the application will do 
- Manage beneficiaries (residents)
- Manage water meters and their status
- Record monthly consumption readings
- Automatically calculate consumption and invoice amounts
- Generate and archive invoices
- Manage payments (full or partial)
- Track unpaid invoices
- Record meter repairs
- Track financial losses related to repairs
- Generate statistics and financial reports

### 3.2 What the application will not do 
- Online payment via banking services
- Dedicated mobile application
- Management of multiple villages (initial version)

---

## 4. Actors / User Types

### 4.1  Administrator
Association member responsible for overall system management.

**Responsibilities:**
- User management
- Supervision of meters and invoices
- Consultation of reports and statistics
- Validation of financial data

### 4.2  Repair Manager
Person responsible for water meter maintenance and repair.

**Responsibilities:**
- Report meter breakdowns
- Record completed repairs
- Enter repair-related costs
- Track meter status (functional / broken)

### 4.3  Collection Agent
Person responsible for collecting payments from residents at month-end.

**Responsibilities:**
- Record payments made by beneficiaries
- Update invoice status (paid, partially paid, unpaid)
- View list of beneficiaries with overdue payments

### 4.4  Beneficiary (indirect user)
Village resident benefiting from drinking water service.

**Role:**
- Consume water
- Pay monthly invoices

---

## 5. Main Features

### 5.1 Essential Features 
| Feature | Description |
|----------------|-------------|
| **Beneficiary Management** | Add, modify, delete residents |
| **Meter Management** | Assignment, status tracking, location |
| **Monthly Reading Entry** | Record monthly index per meter |
| **Automatic Consumption Calculation** | Difference between readings |
| **Invoice Generation** | Automatic creation of monthly invoices |
| **Payment Management** | Record and track payments |

### 5.2 Secondary Features 
| Feature | Description |
|----------------|-------------|
| **Repair Management** | Intervention history |
| **Financial Loss Tracking** | Monitoring of breakdown-related costs |
| **Monthly and Annual Reports** | Financial summaries |
| **Statistics** | Consumption and billing analysis |

---

## 6. User Stories

###  Administrator
> *"As an **administrator**, I want to **manage beneficiaries** to ensure accurate tracking."*

> *"As an **administrator**, I want to **generate invoices** to correctly bill consumption."*

###  Repair Manager
> *"As a **repair manager**, I want to **record a repair** to track costs."*

> *"As a **repair manager**, I want to **check meter status** to anticipate breakdowns."*

###  Collection Agent
> *"As a **collection agent**, I want to **record payments** to update invoices."*

> *"As a **collection agent**, I want to **view unpaid invoices** to follow up with beneficiaries."*

---

## 7. Initial Product Backlog

###  Essential Features (High Priority)
- [ ] Beneficiary Management
- [ ] Meter Management
- [ ] Consumption Readings
- [ ] Automatic Billing
- [ ] Payment Management

### Important Features (Medium Priority)
- [ ] Repair Management
- [ ] Financial Loss Tracking
- [ ] Financial Reports
- [ ] Monthly Statistics

---

##  Technologies

| Layer | Technology |
|--------|-------------|
| **Frontend** | HTML5, CSS3, JavaScript |
| **Backend** |  PHP/Laravel |
| **Database** | MySQL  |

---

