INSERT INTO `hospital_departments`(`id`, `company_id`, `name`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Outpatient department (OPD)', '<p><span style="color: rgb(32, 33, 34);">An&nbsp;</span>outpatient department&nbsp;or&nbsp;outpatient clinic&nbsp;is the part of a hospital&nbsp;designed for the treatment of outpatients, people with health problems who visit the hospital for diagnosis or treatment, but do not at this time require a bed or to be admitted for overnight care. Modern outpatient departments offer a wide range of treatment services, diagnostic tests and minor surgical procedures.</p>', '1', '2021-12-02 11:17:52', '2021-12-02 11:17:52', NULL),
(2, 1, 'Inpatient Service (IP)', '<p><span style="color: rgb(33, 37, 41);">Inpatient care requires overnight hospitalization. Patients must stay at the medical facility where their procedure was done (which is usually a hospital) for at least one night. During this time, they remain under the supervision of a nurse or doctor.</span></p>', '1', '2021-12-02 11:20:55', '2021-12-02 11:20:55', NULL),
(3, 1, 'Medical Department', '<p><span style="color: rgb(32, 33, 36);">Medical Department. The medical department has within it the various clinical services. They are:&nbsp;medicine, surgery, gynaecology, obstetrics, paediatrics, eye, ENT, dental, orthopaedics, neurology, cardiology, psychiatry, skin, V.D., plastic surgery, nuclear medicine, infectious disease etc.</span></p>', '1', '2021-12-02 11:54:29', '2021-12-02 11:54:29', NULL),
(4, 1, 'Nursing Department', '<p><span style="color: rgb(0, 0, 0);">Medical-surgical nursing is one of the most common types of nursing. Not so long ago, all nursing grads started out as a medical-surgical nurse. However, today the nursing specialty path is not so straight forward. A medical-surgical nurse typically manages a patient load of five to seven patients throughout their shift.</span></p>', '1', '2021-12-02 11:57:47', '2021-12-02 11:57:47', NULL),
(5, 1, 'Paramedical Department', '<p><span style="color: rgb(32, 33, 34);">A&nbsp;paramedic&nbsp;is a health care professional whose primary role is to provide advanced&nbsp;</span>emergency medical care<span style="color: rgb(32, 33, 34);">&nbsp;for critical and emergent patients who access the emergency medical system.</span></p>', '1', '2021-12-02 11:59:24', '2021-12-02 11:59:24', NULL),
(6, 1, 'Operation Theatre Complex (OT)', '<p><span style="color: rgb(51, 51, 51);">An operation theatre complex is the "heart" of any major surgical hospital. An operating theatre, operating room, surgery suite or a surgery centre is a room within a hospital within which surgical and other operations are carried out. Operating theatres were so-called in the United Kingdom because they traditionally consisted of semi-cir-cular amphitheatres to allow students to observe the medi-cal procedures</span></p>', '1', '2021-12-02 12:01:17', '2021-12-02 12:01:17', NULL),
(7, 1, 'Pharmacy Department', '<p><span style="color: rgb(5, 5, 5);">The Department of Pharmacy at Southeast University was established in May, 2002. The aim of the introduction of Pharmacy program in Southeast University is to prepare students to be the most competent, responsible and caring Pharmacist/Pharmaceutical Scientist. The curriculum is designed to produce skilled and efficient professionals to manage pharmaceutical industries, hospital pharmacy, community pharmacy service and other government bodies related to health service and to be very competitive with other national and international universities.</span></p>', '1', '2021-12-02 12:02:25', '2021-12-02 12:02:25', NULL),
(8, 1, 'Radiology Department (X-ray)', '<p><span style="color: rgb(0, 0, 0);">Although better known as the ‘X-ray Department’, we do a lot more than just take X-rays! We offer almost all of the latest types of medical imaging techniques to support Doctors, Nurses and other Healthcare Professional to diagnose and work with you to treat you in the best possible way. We are located on the ground floor of the main hospital building.</span></p>', '1', '2021-12-02 12:03:54', '2021-12-02 12:03:54', NULL);

INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `photo`, `locale`, `date_of_birth`, `gender`, `blood_group`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 1, 'Dr. Abdu', 'dr.abdu@gmail.com', NULL, '$2y$10$Co3AM93V.ovtn7wVK8yorecZ6skNEs3sWL4nTmbGOLLxNVH18q5A6', '(833) 286-7393', NULL, 'storage/user-images/TV3dVzPIvKR5xssGl1vmdEMPUmMkaOCjlXK7PG2y.png', NULL, '1965-01-04', 'male', 'A+', '1', NULL, '2021-12-06 06:55:04', '2021-12-06 07:52:13', NULL),
(8, 1, 'Dr. Myles', 'dr.myles@gmail.com', NULL, '$2y$10$QQDiuMl9e9Cvw4sgJIXtT.hSV0/zLCVeBOWZ/8N44dBoM4xQgPoIm', '07700 900461', NULL, 'storage/user-images/g771C5GiQAiYvgq29aYZp8cyLoZCJCHNI1nehhAq.png', NULL, '1960-02-04', 'male', 'A-', '1', NULL, '2021-12-06 06:59:05', '2021-12-06 07:52:56', NULL),
(9, 1, 'Dr. Fouad', 'dr.fouad@gmail.com', NULL, '$2y$10$IWSg7hlSHRtGnX4wO4iPBOpK33oGVxmgGdrh64eSYIZBidtYB1zC2', '818-836-8040', NULL, 'storage/user-images/45wO54FnhiHBfErLkHXUS67tBiAyHS1gsT1hrkrP.jpg', NULL, '1975-03-01', 'male', 'B+', '1', NULL, '2021-12-06 07:03:10', '2021-12-06 07:53:26', NULL),
(10, 1, 'Dr. Khalid Abbed', 'dr.khalid@gmail.com', NULL, '$2y$10$g2Y68SHtQZ8XixudB8aNCuk1wCTz6VHcciC8Xw10jzX8pmNZghxh6', '678-999-8212', NULL, 'storage/user-images/Bdlj0yEukn6wj0ArxyHL2JkcnHzAkgjEbHh2zPfK.png', NULL, '1970-12-23', 'male', 'B-', '1', NULL, '2021-12-06 07:11:28', '2021-12-06 07:11:57', NULL),
(11, 1, 'Dr. Naresh', 'dr.naresh@gmail.com', NULL, '$2y$10$qfBU.uGXm2UsjnjMK33FregDZzrIUt3Dcc5oi4PMXgEtz6.8pUvZm', '800-273-8255', NULL, 'storage/user-images/yckyfTc4ClFCU6irIfJzmk0CX5CU7g8CECbWp9ZJ.jpg', NULL, '1980-05-20', 'male', 'O+', '1', NULL, '2021-12-06 07:14:19', '2021-12-06 07:14:19', NULL),
(12, 1, 'Dr. Arthur Reese Abright', 'dr.arthur@gmail.com', NULL, '$2y$10$UOF9CccK46mYPzGi4O487.sXbp6maCZhLEeDskvNzvazwYxI2SBNK', '(214) 748-3647', NULL, 'storage/user-images/YnQNoCt9olEr1Zu2G8hjRHbNBGvlaeB7sFHuHVlU.png', NULL, '1882-06-10', 'female', 'AB+', '1', NULL, '2021-12-06 07:17:19', '2021-12-06 07:54:00', NULL),
(13, 1, 'Dr. Corrie', 'dr.corrie@gmail.com', NULL, '$2y$10$WhLgoSMiomFwLn2FnsZgvODAdyki24hX/5FDvyOWcWPIW40DqM0Fu', '(281) 330-8004', NULL, 'storage/user-images/4VcJeF2xXsx7Pwn7swxxu9YurhIkluASjYVr1eW8.jpg', NULL, '1975-07-10', 'male', 'AB-', '1', NULL, '2021-12-06 07:28:36', '2021-12-06 07:28:36', NULL),
(14, 1, 'Dr. Mark', 'dr.mark@gmail.com', NULL, '$2y$10$ogrmSeUhW619bXKRyX6cN.FWw4M7DoqbN7Msm55krRrrUHcR2vOem', '678-999-8212', NULL, 'storage/user-images/tx3AOLGot8YXJBGA3XOqQTsJyKynDK76WaQnNp7g.jpg', NULL, '1980-12-10', 'male', 'B+', '1', NULL, '2021-12-06 07:31:31', '2021-12-06 07:31:31', NULL),
(15, 1, 'Dr. Sudhansu', 'dr.sudhansu@gmail.com', NULL, '$2y$10$KloLUDP/YzRzb7kCxz3ZmOmvQRzZgRJxkUZqHsPOO7GSE4KNwr.xW', '800-273-8255', NULL, 'storage/user-images/jdDeTO8YUH5dYedJUvBGq1FencQkROkBogfPPx40.jpg', NULL, '1988-07-07', 'male', 'B+', '1', NULL, '2021-12-06 07:34:00', '2021-12-06 07:35:01', NULL),
(16, 1, 'Dr.Mona', 'dr.mona@gmail.com', NULL, '$2y$10$5za8txiorLMBIUScRtUakOmpK1iz9eU8pj4fxIzUIGBKJmNy91m.m', NULL, NULL, 'storage/user-images/VNmzH6TLFcJ4BLtqBS5Tgrrdw4eK8iHCZMrP1OLn.jpg', NULL, '1990-10-04', 'female', 'A+', '1', NULL, '2021-12-06 07:37:06', '2021-12-06 07:38:14', NULL),
(17, 1, 'Dr. Abaza', 'dr.abaza@gmail.com', NULL, '$2y$10$Xf4SwAQK0Echo3CCvqBvYuL295roEyKCyY4evmzMSdqXuvNkiswli', '(214) 748-3647', NULL, 'storage/user-images/RFGG7qqwOtallJG5XMlNcWOWBFKi54PJoY9HklQY.jpg', NULL, '1986-09-19', NULL, NULL, '1', NULL, '2021-12-06 07:40:13', '2021-12-06 07:57:07', NULL),
(18, 1, 'Dr. Abu Saleh Mohiuddin', 'dr.abusaleh@gmail.com', NULL, '$2y$10$bIDPjQX.E8AGvy2F9PNct.HxnKq/jYvVJRO3vUNOAIQweNJkRTWiS', '+880-2-9350383', NULL, 'storage/user-images/eiHSiFGac7FmaxzC7NG5MJG1gcJJ2NDULgHJ0IGv.jpg', NULL, '1977-10-10', 'male', 'B+', '1', NULL, '2021-12-06 07:43:45', '2021-12-06 07:56:37', NULL),
(19, 1, 'Dr. Enamul Haque Chowdhury', 'dr.enamul@gmail.com', NULL, '$2y$10$AHj5pQT96zmEMF91jS4Lb.HQanB1xLtLUZm0ArtS2YJwMMJdH1c96', '880-2-9122689', NULL, 'storage/user-images/rR1p2J2WroxnwTHA5kKEWUHgPsHUYOlrHjtoXra5.png', NULL, '1984-08-09', 'male', 'B+', '1', NULL, '2021-12-06 07:47:13', '2021-12-06 07:56:05', NULL);

INSERT INTO `user_companies` (user_id,company_id,user_type) VALUES (7,1,'App\\Models\\User'), (8,1,'App\\Models\\User'), (9,1,'App\\Models\\User'), (10,1,'App\\Models\\User'), (11,1,'App\\Models\\User'), (12,1,'App\\Models\\User'), (13,1,'App\\Models\\User'), (14,1,'App\\Models\\User'), (15,1,'App\\Models\\User'),
(16,1,'App\\Models\\User'), (17,1,'App\\Models\\User'), (18,1,'App\\Models\\User'), (19,1,'App\\Models\\User');

INSERT INTO `model_has_roles` (role_id,model_type,model_id) VALUES (2,'App\\Models\\User',7), (2,'App\\Models\\User',8), (2,'App\\Models\\User',9), (2,'App\\Models\\User',10), (2,'App\\Models\\User',11), (2,'App\\Models\\User',12), (2,'App\\Models\\User',13), (2,'App\\Models\\User',14), (2,'App\\Models\\User',15),
(2,'App\\Models\\User',16), (2,'App\\Models\\User',17), (2,'App\\Models\\User',18), (2,'App\\Models\\User',19);

INSERT INTO `doctor_details` (`id`, `hospital_department_id`, `user_id`, `specialist`, `designation`, `biography`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Outpatient Department', 'MBBS', '<p><br></p>', '2021-12-06 06:48:05', '2021-12-06 07:50:28'),
(2, 1, 7, 'Orthopedics', 'M.D, M.S.', '<p><br></p>', '2021-12-06 06:55:04', '2021-12-06 06:55:04'),
(3, 2, 8, 'Pediatricians', 'M.D.', '<p><br></p>', '2021-12-06 06:59:05', '2021-12-06 06:59:05'),
(4, 2, 9, 'Gynecologist/Oncologist', 'FCPS', '<p><br></p>', '2021-12-06 07:03:10', '2021-12-06 07:03:10'),
(5, 3, 10, 'Neurosurgery', 'MBBS', '<p><br></p>', '2021-12-06 07:11:28', '2021-12-06 07:11:28'),
(6, 3, 11, 'Cardiovascular', 'FCPS', '<p><br></p>', '2021-12-06 07:14:19', '2021-12-06 07:14:19'),
(7, 5, 12, 'Psychiatry', 'MBBS', '<p><br></p>', '2021-12-06 07:17:19', '2021-12-06 07:17:19'),
(8, 5, 13, 'Pediatric Anesthesiologist', 'MBBS', '<p><br></p>', '2021-12-06 07:28:36', '2021-12-06 07:28:36'),
(9, 6, 14, 'Cardiologists', 'MBBS', '<p><br></p>', '2021-12-06 07:31:31', '2021-12-06 07:31:31'),
(10, 6, 15, 'Cardiovascular Surgeons', 'MCH', '<p><br></p>', '2021-12-06 07:34:01', '2021-12-06 07:34:01'),
(11, 7, 16, 'Otolaryngologist', 'MD', '<p><br></p>', '2021-12-06 07:37:06', '2021-12-06 07:38:14'),
(12, 7, 17, 'Pharmacy', 'MBBS', '<p><br></p>', '2021-12-06 07:40:13', '2021-12-06 07:40:13'),
(13, 8, 18, 'Radiology & Imaging', 'MBBS, DMRD, MD (Radiology)', '<p><br></p>', '2021-12-06 07:43:45', '2021-12-06 07:43:45'),
(14, 8, 19, 'Radiology & Imaging', 'Professor, Department of Radiology', '<p><br></p>', '2021-12-06 07:47:13', '2021-12-06 07:47:13');

INSERT INTO `doctor_schedules` (`id`, `user_id`, `weekday`, `start_time`, `end_time`, `avg_appointment_duration`, `serial_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'Friday', '00:00:00', '23:59:00', 30, 'Sequential', '1', '2021-12-06 08:08:06', '2021-12-06 08:08:06'),
(2, 2, 'Saturday', '00:00:00', '23:59:00', 30, 'Timestamp', '1', '2021-12-06 08:08:43', '2021-12-06 08:08:52'),
(3, 2, 'Sunday', '00:00:00', '23:59:00', 30, 'Sequential', '1', '2021-12-06 08:10:58', '2021-12-06 08:10:58'),
(4, 2, 'Monday', '00:00:00', '23:59:00', 30, 'Timestamp', '1', '2021-12-06 08:11:27', '2021-12-06 08:11:27'),
(5, 2, 'Tuesday', '00:00:00', '23:59:00', 30, 'Sequential', '1', '2021-12-06 08:12:21', '2021-12-06 08:12:21'),
(6, 2, 'Wednesday', '00:00:00', '23:59:00', 30, 'Timestamp', '1', '2021-12-06 08:13:23', '2021-12-06 08:13:23'),
(7, 2, 'Thursday', '00:00:00', '23:59:00', 30, 'Timestamp', '1', '2021-12-06 08:14:02', '2021-12-06 08:14:02');

INSERT INTO `patient_appointments` (`id`, `user_id`, `doctor_id`, `sequence`, `start_time`, `end_time`, `appointment_date`, `problem`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 5, '02:00:00', '02:30:00', '2021-12-10', 'Matha Betha', '2021-12-06 08:16:46', '2021-12-06 08:16:46'),
(2, 3, 2, 17, '08:00:00', '08:30:00', '2021-12-11', 'Jor Jor Vab', '2021-12-06 08:17:37', '2021-12-06 08:17:37'),
(3, 3, 2, 13, '06:00:00', '06:30:00', '2021-12-14', 'BP Problem', '2021-12-06 08:18:39', '2021-12-06 08:18:39');