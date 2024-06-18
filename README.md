# Inventory Management System

## Introduction

This project is an Inventory Management System built using Laravel. It is designed to manage and track inventory, expenditures, and revenues.

## Current Progress

### Database Migrations

The following tables have been created:

- **Persediaan**: Manages the inventory.
- **Pengeluaran**: Tracks expenditures.
- **Pendapatan**: Tracks revenues.

#### Persediaan Table

- `id_persediaan`: UUID (Primary Key)
- `nama_barang`: String
- `harga_pcs`: Integer
- `jumlah_persediaan`: Integer
- `created_at`: Timestamp
- `updated_at`: Timestamp

#### Pengeluaran Table

- `id_pengeluaran`: UUID (Primary Key)
- `jenis_pengeluaran`: Tiny Integer
- `barang`: UUID (Foreign Key to `id_persediaan`)
- `harga`: Integer
- `jumlah`: Integer
- `deskripsi`: String
- `tanggal_pengeluaran`: Timestamp
- `created_at`: Timestamp
- `updated_at`: Timestamp

#### Pendapatan Table

- `id_pendapatan`: UUID (Primary Key)
- `jenis_pendapatan`: Tiny Integer
- `barang`: UUID (Foreign Key to `id_persediaan`)
- `harga`: Integer
- `jumlah`: Integer
- `deskripsi`: String
- `tanggal_pendapatan`: Timestamp
- `created_at`: Timestamp
- `updated_at`: Timestamp

### Models

Models for each table have been created with appropriate relationships and attributes:

#### Persediaan Model

- Attributes: `id_persediaan`, `nama_barang`, `harga_pcs`, `jumlah_persediaan`
- Relationships: Has many `Pengeluaran`, Has many `Pendapatan`

#### Pengeluaran Model

- Attributes: `id_pengeluaran`, `jenis_pengeluaran`, `barang`, `harga`, `jumlah`, `deskripsi`, `tanggal_pengeluaran`
- Relationships: Belongs to `Persediaan`

#### Pendapatan Model

- Attributes: `id_pendapatan`, `jenis_pendapatan`, `barang`, `harga`, `jumlah`, `deskripsi`, `tanggal_pendapatan`
- Relationships: Belongs to `Persediaan`

### Controllers

Resource controllers have been created for each model to handle CRUD operations:

#### PersediaanController

- Methods: `index`, `store`, `show`, `update`, `destroy`

#### PengeluaranController

- Methods: `index`, `store`, `show`, `update`, `destroy`

#### PendapatanController

- Methods: `index`, `store`, `show`, `update`, `destroy`

### Next Steps
1. Validation and Error Handling: Improve validation rules and error handling in controllers.
2. API Documentation: Document the API endpoints using Swagger or a similar tool.
3. Authentication and Authorization: Implement user authentication and role-based access control.
4. Frontend Integration: Develop a frontend interface to interact with the API.
5. Testing: Write unit tests and integration tests for all functionalities.


### Installation
To set up the project locally:
1. Clone the repository : `git clone https://github.com/fatur-bbx/BadminZone.git`
2. Navigate to the project directory : `cd BadminZone`
3. Install dependencies : `composer install`
4. Create a copy of the .env file : `cp .env.example .env`
5. Generate an application key : `php artisan key:generate`
6. Run the migrations : `php artisan migrate`