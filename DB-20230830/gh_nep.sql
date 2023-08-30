-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2023 at 02:02 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gh_nep`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_credits`
--

CREATE TABLE `academic_credits` (
  `id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `credit_number` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `session` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `academic_master`
--

CREATE TABLE `academic_master` (
  `academic_year_id` int(11) NOT NULL,
  `from_date` varchar(20) NOT NULL,
  `to_date` varchar(20) NOT NULL,
  `batch_code` varchar(75) NOT NULL,
  `short_code` varchar(30) NOT NULL,
  `status` int(80) NOT NULL,
  `department` int(10) NOT NULL DEFAULT 0,
  `session` int(3) NOT NULL DEFAULT 0,
  `academic_year` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_master`
--

INSERT INTO `academic_master` (`academic_year_id`, `from_date`, `to_date`, `batch_code`, `short_code`, `status`, `department`, `session`, `academic_year`) VALUES
(1, '01/06/2023', '31/05/2027', 'BA-23-27', 'BA-2023-27', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `year_id` tinyint(4) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `active_year` tinyint(2) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`year_id`, `academic_year`, `active_year`, `status`) VALUES
(1, '2023', 1, 1),
(2, '2024', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `account_master`
--

CREATE TABLE `account_master` (
  `id` int(11) NOT NULL,
  `acc_name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `acc_number` varchar(50) DEFAULT NULL,
  `last_modified_date` date NOT NULL,
  `created_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_master`
--

INSERT INTO `account_master` (`id`, `acc_name`, `status`, `acc_number`, `last_modified_date`, `created_date`) VALUES
(1, 'Prod 1', 0, '1234567890', '0000-00-00', '2023-08-24'),
(2, 'Prod 2', 0, '9876543210', '0000-00-00', '2023-08-24');

-- --------------------------------------------------------

--
-- Table structure for table `accu_grade_allocation_items`
--

CREATE TABLE `accu_grade_allocation_items` (
  `grade_allocation_item_id` bigint(20) NOT NULL,
  `grade_allocation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_id` varchar(100) NOT NULL,
  `grade_value` varchar(50) NOT NULL,
  `number_value` varchar(50) DEFAULT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `publish_date` date NOT NULL DEFAULT '0000-00-00',
  `flag` char(1) NOT NULL,
  `reval_status` char(1) NOT NULL DEFAULT '0',
  `obtained_marks` int(4) NOT NULL DEFAULT 0,
  `total_marks` int(4) NOT NULL DEFAULT 0,
  `percent` float(4,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addons_ref_grade_manual`
--

CREATE TABLE `addons_ref_grade_manual` (
  `id` int(11) NOT NULL,
  `Level of Performance` varchar(100) NOT NULL,
  `Grade` varchar(10) NOT NULL,
  `Grading Scale (%)` varchar(100) NOT NULL,
  `flag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_courses_allotment`
--

CREATE TABLE `addon_courses_allotment` (
  `id` int(11) NOT NULL,
  `stu_id` varchar(50) NOT NULL,
  `addon_course_id` int(11) NOT NULL,
  `addon_course_fee` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `academic_year` int(11) NOT NULL DEFAULT 5
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_courses_list`
--

CREATE TABLE `addon_courses_list` (
  `id` int(11) NOT NULL,
  `stu_id` varchar(50) NOT NULL,
  `addon_course_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `academic_year` int(11) NOT NULL,
  `exam_roll` varchar(110) NOT NULL,
  `reg_no` varchar(110) NOT NULL,
  `stu_name` varchar(110) NOT NULL,
  `class_roll` varchar(10) NOT NULL,
  `department` varchar(100) NOT NULL,
  `course_code` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_course_master`
--

CREATE TABLE `addon_course_master` (
  `course_id` int(11) NOT NULL,
  `addon_course_id` int(11) NOT NULL,
  `course_code` varchar(30) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_description` varchar(400) NOT NULL,
  `status` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_course_master_item`
--

CREATE TABLE `addon_course_master_item` (
  `id` int(11) NOT NULL,
  `addon_mater_id` int(11) NOT NULL,
  `fee` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `tot_credit` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `empl_id` varchar(20) DEFAULT NULL,
  `filename` text DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_course_mater`
--

CREATE TABLE `addon_course_mater` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `conductedby` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `code` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_evaluation_componets_master`
--

CREATE TABLE `addon_evaluation_componets_master` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `hod_id` varchar(10) NOT NULL,
  `addon_course_id` int(11) NOT NULL,
  `academic_year_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_evaluation_componets_master_items`
--

CREATE TABLE `addon_evaluation_componets_master_items` (
  `id` int(11) NOT NULL,
  `ec_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `component_name` varchar(50) NOT NULL,
  `weightage` float NOT NULL,
  `remaining_weightage` float NOT NULL,
  `component_id` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_grade_allocation_items`
--

CREATE TABLE `addon_grade_allocation_items` (
  `grade_allocation_item_id` int(11) NOT NULL,
  `grade_allocation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_id` varchar(100) NOT NULL,
  `grade_value` varchar(50) NOT NULL,
  `number_value` varchar(50) DEFAULT NULL,
  `reval_date` datetime NOT NULL,
  `publish_date` date NOT NULL,
  `flag` char(1) DEFAULT 'R',
  `obtained_marks` int(4) NOT NULL DEFAULT 0,
  `total_marks` int(4) NOT NULL DEFAULT 0,
  `percent` float(4,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_grade_allocation_master`
--

CREATE TABLE `addon_grade_allocation_master` (
  `grade_id` int(11) NOT NULL,
  `academic_id` int(11) DEFAULT NULL,
  `academic_year` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `published_by_faculty` tinyint(1) NOT NULL DEFAULT 0,
  `published_by_faculty_date` datetime DEFAULT NULL,
  `added_by` char(30) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `added_by_ip_address` varchar(30) DEFAULT NULL,
  `cc_id` int(10) NOT NULL DEFAULT 0,
  `cmn_terms` varchar(10) NOT NULL,
  `department` varchar(10) DEFAULT NULL,
  `ge_id` int(10) NOT NULL DEFAULT 0,
  `session` int(5) NOT NULL DEFAULT 0,
  `degree_id` int(5) NOT NULL,
  `flag` varchar(10) NOT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `csrftoken` text NOT NULL,
  `exam_month` varchar(50) DEFAULT NULL,
  `addon_course_list` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_grade_allocation_report`
--

CREATE TABLE `addon_grade_allocation_report` (
  `grade_report_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `employee_id` varchar(30) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `added_by` char(30) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `added_by_ip_address` varchar(30) DEFAULT NULL,
  `course_id` varchar(50) DEFAULT NULL,
  `cc_id` int(10) DEFAULT 0,
  `ge_id` int(10) NOT NULL DEFAULT 0,
  `session` int(10) DEFAULT NULL,
  `cmn_terms` varchar(10) DEFAULT NULL,
  `tabl_id` bigint(20) NOT NULL,
  `flag` varchar(10) NOT NULL DEFAULT 'R',
  `academic_year` int(11) NOT NULL,
  `addon_course_list` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_grade_allocation_report_items`
--

CREATE TABLE `addon_grade_allocation_report_items` (
  `grade_allocation_report_item_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_grades` text DEFAULT NULL,
  `component_weightages` text DEFAULT NULL,
  `grade_point` float DEFAULT NULL,
  `ge_id` int(5) NOT NULL DEFAULT 0,
  `tabl_id` int(20) NOT NULL DEFAULT 0,
  `sort` tinyint(4) NOT NULL DEFAULT 0,
  `addon_course_list` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_marks_sheets`
--

CREATE TABLE `addon_marks_sheets` (
  `id` int(11) NOT NULL,
  `slno` int(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `form_id` varchar(25) DEFAULT NULL,
  `registration_no` varchar(25) DEFAULT NULL,
  `examination_roll_no` varchar(255) DEFAULT NULL,
  `session` varchar(10) DEFAULT NULL,
  `department_of_student` varchar(50) DEFAULT NULL,
  `conducted_by_department` varchar(255) DEFAULT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `paper_i` varchar(255) DEFAULT NULL,
  `paper_name_i` varchar(255) DEFAULT NULL,
  `paper_code_i` varchar(255) DEFAULT NULL,
  `credits_i` varchar(255) DEFAULT NULL,
  `full_marks_i` varchar(50) DEFAULT NULL,
  `obtained_marks_i` varchar(255) DEFAULT NULL,
  `paper_ii` varchar(255) DEFAULT NULL,
  `paper_name_ii` varchar(255) DEFAULT NULL,
  `paper_code_ii` varchar(255) DEFAULT NULL,
  `credits_ii` varchar(255) DEFAULT NULL,
  `full_marks_ii` varchar(50) DEFAULT NULL,
  `obtained_marks_ii` varchar(50) DEFAULT NULL,
  `paper_iii` varchar(255) DEFAULT NULL,
  `paper_name_iii` varchar(255) DEFAULT NULL,
  `paper_code_iii` varchar(255) DEFAULT NULL,
  `credits_iii` varchar(255) DEFAULT NULL,
  `full_marks_iii` varchar(50) DEFAULT NULL,
  `obtained_marks_iii` varchar(255) DEFAULT NULL,
  `paper_iv` varchar(255) DEFAULT NULL,
  `paper_name_iv` varchar(255) DEFAULT NULL,
  `paper_code_iv` varchar(255) DEFAULT NULL,
  `credits_iv` varchar(255) DEFAULT NULL,
  `full_marks_iv` varchar(255) DEFAULT NULL,
  `obtained_marks_iv` varchar(255) DEFAULT NULL,
  `total_credits` varchar(255) DEFAULT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `gr_total` varchar(255) DEFAULT NULL,
  `obtained_gr_total` varchar(255) DEFAULT NULL,
  `date_of_result` varchar(50) DEFAULT NULL,
  `gradesheet_refrence` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_reference_grade_items`
--

CREATE TABLE `addon_reference_grade_items` (
  `reference_item_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `letter_grade` varchar(15) NOT NULL,
  `number_grade` float NOT NULL,
  `marks_from` int(5) NOT NULL,
  `marks_to` int(5) NOT NULL,
  `des` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_reference_grade_master`
--

CREATE TABLE `addon_reference_grade_master` (
  `reference_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `academic_year` int(5) NOT NULL,
  `addon_course_list` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_tabulation_report`
--

CREATE TABLE `addon_tabulation_report` (
  `tabl_id` int(10) NOT NULL,
  `academic_id` int(10) NOT NULL,
  `term_id` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` varchar(255) NOT NULL,
  `added_date` date NOT NULL DEFAULT '0000-00-00',
  `added_by_ip_address` varchar(255) DEFAULT NULL,
  `flag` varchar(10) NOT NULL DEFAULT 'R',
  `fail` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'if fail student added then 0 else 1',
  `academic_year` int(11) NOT NULL,
  `addon_course_list` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `addon_tabulation_report_items`
--

CREATE TABLE `addon_tabulation_report_items` (
  `id` int(10) NOT NULL,
  `tabl_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `sgpa` float(4,2) DEFAULT NULL,
  `fail_in_ct_ids` varchar(255) DEFAULT NULL,
  `total_credit_point` float DEFAULT NULL,
  `total_grade_point` float DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `promotion_text` text NOT NULL,
  `final_remarks` varchar(2) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `grade_point` varchar(255) NOT NULL,
  `non_col_date` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alumini_association`
--

CREATE TABLE `alumini_association` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `batch` varchar(100) NOT NULL,
  `date_of_birth` varchar(100) NOT NULL,
  `marital_status` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `professional_details` varchar(100) NOT NULL,
  `org_name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `exprience` varchar(100) NOT NULL,
  `time` varchar(100) NOT NULL,
  `reg_amt` varchar(100) NOT NULL,
  `mmp_txn` varchar(100) NOT NULL,
  `mer_txn` varchar(100) NOT NULL,
  `bank_txn` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `prod` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `f_code` varchar(10) NOT NULL,
  `clientcode` varchar(20) NOT NULL,
  `merchant_id` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `pay_mode` varchar(20) NOT NULL,
  `create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announce_result_items`
--

CREATE TABLE `announce_result_items` (
  `id` int(5) NOT NULL,
  `stu_id` varchar(125) NOT NULL,
  `master_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announce_result_master`
--

CREATE TABLE `announce_result_master` (
  `id` int(5) NOT NULL,
  `department_type` int(5) NOT NULL,
  `cutoff_list` int(1) NOT NULL,
  `submit_date` date NOT NULL,
  `ip_address` varchar(225) NOT NULL,
  `published_by` varchar(50) NOT NULL,
  `confirmed_date` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `acad_year_id` int(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_course_details`
--

CREATE TABLE `applicant_course_details` (
  `id` bigint(20) NOT NULL,
  `application_no` varchar(50) NOT NULL DEFAULT '0',
  `applicant_name` varchar(100) NOT NULL DEFAULT '0',
  `email_id` varchar(50) NOT NULL DEFAULT '0',
  `phone` varchar(10) NOT NULL DEFAULT '0',
  `degree_id` int(2) NOT NULL,
  `course` int(2) NOT NULL,
  `session` int(2) NOT NULL DEFAULT 0,
  `core_course1` int(2) NOT NULL DEFAULT 0,
  `ge1` int(2) DEFAULT 0,
  `aecc1` varchar(20) DEFAULT '0',
  `core_course2` int(2) NOT NULL DEFAULT 0,
  `ge2` int(2) DEFAULT 0,
  `aecc2` varchar(20) DEFAULT '0',
  `comp_evs` varchar(20) DEFAULT '0',
  `form_id` varchar(100) NOT NULL DEFAULT '0',
  `form_status` varchar(25) DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT 0,
  `dpt` int(11) NOT NULL,
  `srutiny_flag` int(1) DEFAULT NULL,
  `scrutiny_date` date NOT NULL,
  `acad_year_id` int(2) DEFAULT 0,
  `user_id` varchar(50) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `scrutiny_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant_course_details`
--

INSERT INTO `applicant_course_details` (`id`, `application_no`, `applicant_name`, `email_id`, `phone`, `degree_id`, `course`, `session`, `core_course1`, `ge1`, `aecc1`, `core_course2`, `ge2`, `aecc2`, `comp_evs`, `form_id`, `form_status`, `status`, `dpt`, `srutiny_flag`, `scrutiny_date`, `acad_year_id`, `user_id`, `ip_address`, `scrutiny_status`) VALUES
(1, 'arya0367', 'RAUSHAN', 'arya0367@gmail.com', '8287161976', 1, 2, 1, 0, 0, '0', 0, 0, '0', '0', 'F--1', 'okey', 0, 0, NULL, '0000-00-00', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `applicant_documents_followup`
--

CREATE TABLE `applicant_documents_followup` (
  `id` int(5) NOT NULL,
  `form_id` varchar(100) NOT NULL DEFAULT '0',
  `application_no` varchar(100) NOT NULL,
  `course` int(5) NOT NULL,
  `certificate_list` varchar(225) NOT NULL DEFAULT '0',
  `submit_date` date NOT NULL,
  `update_date` date NOT NULL,
  `principal_status` int(5) DEFAULT 0,
  `fee_status` int(5) NOT NULL DEFAULT 0,
  `fee_slip` int(5) NOT NULL DEFAULT 0,
  `acad_year_id` int(2) DEFAULT 5,
  `system_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_educational_details`
--

CREATE TABLE `applicant_educational_details` (
  `id` bigint(20) NOT NULL,
  `application_no` varchar(50) NOT NULL DEFAULT '0',
  `applicant_name` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `appearingStatus` int(2) NOT NULL DEFAULT 0,
  `school` varchar(50) DEFAULT '0',
  `subject` varchar(225) DEFAULT NULL,
  `i_board` varchar(50) DEFAULT '0',
  `i_division` varchar(10) DEFAULT '0',
  `i_roll` varchar(50) DEFAULT '0',
  `obt_marks_number` int(10) DEFAULT 0,
  `total_marks_number` int(10) DEFAULT 0,
  `percent` int(10) DEFAULT 0,
  `i_pass_year` int(4) DEFAULT 0,
  `l_institution` varchar(50) DEFAULT '0',
  `l_place` varchar(50) DEFAULT '0',
  `educertificate` varchar(100) DEFAULT '0',
  `last_board` varchar(25) DEFAULT '0',
  `l_p_year` int(4) DEFAULT 0,
  `caste_category` varchar(50) DEFAULT '0',
  `caste` varchar(50) DEFAULT '0',
  `certificate_issued` varchar(25) DEFAULT '0',
  `certificate_no` varchar(50) DEFAULT '0',
  `casteCertificate` varchar(225) DEFAULT '0',
  `ExtraCurricularSelection` varchar(100) DEFAULT NULL,
  `photo` varchar(225) DEFAULT NULL,
  `baptism` varchar(225) DEFAULT NULL,
  `mat_board` varchar(100) DEFAULT NULL,
  `mat_school` varchar(100) DEFAULT NULL,
  `mat_division` varchar(10) DEFAULT NULL,
  `mat_subject` varchar(100) DEFAULT NULL,
  `mat_pass_year` varchar(10) DEFAULT NULL,
  `grad_board` varchar(100) DEFAULT NULL,
  `grad_school` varchar(100) DEFAULT NULL,
  `grad_division` varchar(10) DEFAULT NULL,
  `grad_subject` varchar(100) DEFAULT NULL,
  `grad_pass_year` varchar(10) DEFAULT NULL,
  `other_board` varchar(100) DEFAULT NULL,
  `other_school` varchar(100) DEFAULT NULL,
  `other_division` varchar(10) DEFAULT NULL,
  `other_subject` varchar(100) DEFAULT NULL,
  `other_pass_year` varchar(10) DEFAULT NULL,
  `bca_board` varchar(100) DEFAULT NULL,
  `bca_school` varchar(100) DEFAULT NULL,
  `bca_division` varchar(10) DEFAULT NULL,
  `bca_subject` varchar(100) DEFAULT NULL,
  `bca_pass_year` varchar(10) DEFAULT NULL,
  `grad_math_board` varchar(100) DEFAULT NULL,
  `grad_math_school` varchar(100) DEFAULT NULL,
  `grad_math_division` varchar(10) DEFAULT NULL,
  `grad_math_subject` varchar(100) DEFAULT NULL,
  `grad_math_pass_year` varchar(10) DEFAULT NULL,
  `cert_board` varchar(100) DEFAULT NULL,
  `cert_school` varchar(100) DEFAULT NULL,
  `cert_division` varchar(10) DEFAULT NULL,
  `cert_subject` varchar(100) DEFAULT NULL,
  `cert_pass_year` varchar(10) DEFAULT NULL,
  `acad_year_id` int(2) DEFAULT 0,
  `mat_oth_board` varchar(100) NOT NULL,
  `i_oth_board` varchar(100) NOT NULL,
  `grad_oth_board` varchar(100) NOT NULL,
  `last_oth_board` varchar(100) NOT NULL,
  `bca_oth_board` varchar(100) NOT NULL,
  `grad_oth_math_board` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant_educational_details`
--

INSERT INTO `applicant_educational_details` (`id`, `application_no`, `applicant_name`, `email_id`, `phone`, `appearingStatus`, `school`, `subject`, `i_board`, `i_division`, `i_roll`, `obt_marks_number`, `total_marks_number`, `percent`, `i_pass_year`, `l_institution`, `l_place`, `educertificate`, `last_board`, `l_p_year`, `caste_category`, `caste`, `certificate_issued`, `certificate_no`, `casteCertificate`, `ExtraCurricularSelection`, `photo`, `baptism`, `mat_board`, `mat_school`, `mat_division`, `mat_subject`, `mat_pass_year`, `grad_board`, `grad_school`, `grad_division`, `grad_subject`, `grad_pass_year`, `other_board`, `other_school`, `other_division`, `other_subject`, `other_pass_year`, `bca_board`, `bca_school`, `bca_division`, `bca_subject`, `bca_pass_year`, `grad_math_board`, `grad_math_school`, `grad_math_division`, `grad_math_subject`, `grad_math_pass_year`, `cert_board`, `cert_school`, `cert_division`, `cert_subject`, `cert_pass_year`, `acad_year_id`, `mat_oth_board`, `i_oth_board`, `grad_oth_board`, `last_oth_board`, `bca_oth_board`, `grad_oth_math_board`) VALUES
(1, 'arya0367', 'RAUSHAN', 'arya0367@gmail.com', '8287161976', 0, 'fgf', 'sfg', 'BSEB', 'sfg', '0', 0, 0, 0, 2018, '0', '0', '0', '0', 0, 'General', '0', '0', '0', '0', 'NCC', 'public/images/applicant_photo/arya0367.jpg', 'public/images/applicant_baptism/arya0367.jpg', 'BSEB', 'dfsdf', 'dfdf', 'dfdf', '2016', 'Patna University', 'fgf', 'fg', 'fg', '2021', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_fee_account`
--

CREATE TABLE `applicant_fee_account` (
  `id` int(5) NOT NULL,
  `form_id` varchar(225) NOT NULL,
  `slip_account_type` varchar(150) NOT NULL,
  `cmn_terms` varchar(5) NOT NULL,
  `account1` varchar(50) NOT NULL,
  `total_fee1` int(10) NOT NULL,
  `account2` varchar(20) DEFAULT '0',
  `total_fee2` int(10) DEFAULT 0,
  `status` int(2) NOT NULL,
  `acad_year_id` int(2) DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_payement_details`
--

CREATE TABLE `applicant_payement_details` (
  `id` bigint(20) NOT NULL,
  `application_no` varchar(50) NOT NULL DEFAULT '0',
  `applicant_name` varchar(25) NOT NULL,
  `form_id` varchar(50) NOT NULL DEFAULT '0',
  `email_id` varchar(50) NOT NULL DEFAULT '0',
  `phone` varchar(10) NOT NULL,
  `course` int(10) NOT NULL DEFAULT 0,
  `form_fee` int(10) DEFAULT 0,
  `submit_date` date NOT NULL,
  `college_account_name` varchar(100) NOT NULL DEFAULT '0',
  `payment_mode` varchar(25) NOT NULL,
  `challan_no` varchar(100) NOT NULL DEFAULT '0',
  `payment_status` int(2) NOT NULL DEFAULT 0,
  `roll_no` bigint(20) NOT NULL DEFAULT 0,
  `srutiny_flag` int(1) DEFAULT NULL,
  `scrutiny_date` date NOT NULL,
  `acad_year_id` int(11) NOT NULL DEFAULT 6
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_payment_record`
--

CREATE TABLE `applicant_payment_record` (
  `id` int(11) NOT NULL,
  `application_id` varchar(50) NOT NULL,
  `form_id` varchar(50) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `exam_fee` varchar(50) DEFAULT NULL,
  `submit_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `mmp_txn` varchar(50) NOT NULL,
  `mer_txn` varchar(50) NOT NULL,
  `bank_txn` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `prod` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `f_code` varchar(50) NOT NULL,
  `clientcode` varchar(50) NOT NULL,
  `merchant_id` varchar(50) NOT NULL,
  `payment_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_paymode_details`
--

CREATE TABLE `applicant_paymode_details` (
  `id` int(15) NOT NULL,
  `form_id` varchar(100) NOT NULL,
  `application_no` varchar(100) NOT NULL,
  `course` int(5) NOT NULL DEFAULT 0,
  `pay_mode1` varchar(10) NOT NULL,
  `pay_mode2` varchar(10) NOT NULL,
  `account_name1` varchar(50) NOT NULL,
  `account_name2` varchar(50) NOT NULL,
  `amount1` int(20) NOT NULL,
  `amount2` varchar(12) NOT NULL,
  `unique_id1` varchar(50) NOT NULL,
  `unique_id2` varchar(50) NOT NULL,
  `date_time1` varchar(50) NOT NULL,
  `date2` varchar(50) NOT NULL,
  `bank_id1` varchar(25) NOT NULL,
  `bank_id2` varchar(25) NOT NULL,
  `class_roll` int(10) NOT NULL DEFAULT 0,
  `submit_date` date NOT NULL,
  `update_date` date NOT NULL,
  `acad_year_id` int(2) DEFAULT 5,
  `user_id` varchar(20) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `applicant_personal_details`
--

CREATE TABLE `applicant_personal_details` (
  `id` bigint(20) NOT NULL,
  `application_no` varchar(50) NOT NULL DEFAULT '0',
  `applicant_name` varchar(100) NOT NULL DEFAULT '0',
  `email_id` varchar(255) NOT NULL DEFAULT '0',
  `phone_number` varchar(10) NOT NULL DEFAULT '0',
  `dob_date` varchar(16) NOT NULL DEFAULT '0',
  `gender` int(2) NOT NULL DEFAULT 0,
  `aadhar_number` varchar(50) NOT NULL DEFAULT '0',
  `nationality` varchar(10) NOT NULL DEFAULT '0',
  `religion` varchar(25) NOT NULL DEFAULT '0',
  `others_religion` varchar(255) DEFAULT NULL,
  `father_name` varchar(50) NOT NULL DEFAULT '0',
  `father_qual` varchar(50) NOT NULL DEFAULT '',
  `father_occup` varchar(225) DEFAULT '0',
  `mother_name` varchar(25) NOT NULL DEFAULT '0',
  `mother_qual` varchar(100) DEFAULT '0',
  `mother_occup` varchar(225) DEFAULT '0',
  `guard_name` varchar(50) DEFAULT NULL,
  `guard_qual` varchar(50) DEFAULT NULL,
  `guard_occup` varchar(225) DEFAULT '0',
  `guard_contact` varchar(10) DEFAULT '0',
  `father_contact` varchar(25) NOT NULL,
  `mother_contact` varchar(25) DEFAULT NULL,
  `p_address` varchar(200) NOT NULL DEFAULT '0',
  `p_homeTown` varchar(100) NOT NULL DEFAULT '0',
  `p_postOffice` varchar(100) NOT NULL DEFAULT '0',
  `p_policeSt` varchar(100) NOT NULL DEFAULT '0',
  `p_district` varchar(100) NOT NULL DEFAULT '0',
  `p_state` varchar(150) NOT NULL DEFAULT '0',
  `p_code_number` varchar(6) NOT NULL DEFAULT '0',
  `same_address` int(2) DEFAULT NULL,
  `l_address` varchar(200) NOT NULL DEFAULT '0',
  `l_homeTown` varchar(100) NOT NULL DEFAULT '0',
  `l_postOffice` varchar(100) NOT NULL DEFAULT '0',
  `l_policeSt` varchar(100) NOT NULL DEFAULT '0',
  `l_district` varchar(100) NOT NULL DEFAULT '0',
  `l_state` varchar(100) NOT NULL DEFAULT '0',
  `l_code_number` varchar(6) NOT NULL DEFAULT '0',
  `blood_group` varchar(50) DEFAULT NULL,
  `acad_year_id` int(2) DEFAULT 0,
  `country` varchar(50) NOT NULL,
  `oth_country` varchar(50) NOT NULL,
  `i_country` varchar(100) DEFAULT NULL,
  `i_oth_country` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant_personal_details`
--

INSERT INTO `applicant_personal_details` (`id`, `application_no`, `applicant_name`, `email_id`, `phone_number`, `dob_date`, `gender`, `aadhar_number`, `nationality`, `religion`, `others_religion`, `father_name`, `father_qual`, `father_occup`, `mother_name`, `mother_qual`, `mother_occup`, `guard_name`, `guard_qual`, `guard_occup`, `guard_contact`, `father_contact`, `mother_contact`, `p_address`, `p_homeTown`, `p_postOffice`, `p_policeSt`, `p_district`, `p_state`, `p_code_number`, `same_address`, `l_address`, `l_homeTown`, `l_postOffice`, `l_policeSt`, `l_district`, `l_state`, `l_code_number`, `blood_group`, `acad_year_id`, `country`, `oth_country`, `i_country`, `i_oth_country`) VALUES
(1, 'arya0367', 'RAUSHAN', 'arya0367@gmail.com', '8287161976', '01/01/2000', 1, '974563210', 'Indian', 'Hindu', NULL, 'TESTDD', 'vbcvb', 'vbvb', 'FFDF', '', '', '', '', '', '', '987456320', '', 'kalyanpur', 'Barhiya', 'B Dariyapur', 'barahiya', 'Lakhisarai', 'Bihar', '811302', 1, 'kalyanpur', 'Barhiya', 'B Dariyapur', 'barahiya', 'Lakhisarai', 'Bihar', '811302', 'O+', 0, '1', '', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_registration`
--

CREATE TABLE `applicant_registration` (
  `id` int(11) NOT NULL,
  `applicant_name` varchar(100) DEFAULT NULL,
  `email_id` varchar(100) NOT NULL,
  `phone_number` char(12) NOT NULL,
  `otp` int(6) NOT NULL,
  `password` varchar(100) DEFAULT '123456',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `ip` varchar(100) DEFAULT NULL,
  `application_no` varchar(20) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `acad_year_id` int(2) DEFAULT 0,
  `course` varchar(50) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `session` int(11) NOT NULL,
  `whatsapp_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicant_registration`
--

INSERT INTO `applicant_registration` (`id`, `applicant_name`, `email_id`, `phone_number`, `otp`, `password`, `status`, `ip`, `application_no`, `created_date`, `acad_year_id`, `course`, `degree`, `department`, `session`, `whatsapp_number`) VALUES
(1, 'RAUSHAN', 'arya0367@gmail.com', '8287161976', 0, '123456', 1, '::1', 'arya0367', '2023-08-17 11:23:33', 1, '2', '1', '2', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `application_id` int(11) NOT NULL,
  `stu_id` varchar(50) NOT NULL,
  `batch_id` varchar(50) NOT NULL,
  `term_id` int(10) NOT NULL DEFAULT 0,
  `course_id` varchar(80) DEFAULT NULL,
  `term_id_b` int(10) NOT NULL DEFAULT 0,
  `course_id_b` varchar(80) DEFAULT NULL,
  `course_fee` float NOT NULL,
  `course_fee_b` float NOT NULL,
  `updated_date` date NOT NULL,
  `stu_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `total_fee` varchar(100) NOT NULL,
  `allocated` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apps_countries`
--

CREATE TABLE `apps_countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_submitted`
--

CREATE TABLE `assignment_submitted` (
  `submitted_id` int(10) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `assignment_status` tinyint(4) NOT NULL DEFAULT 0,
  `notification_status` tinyint(4) NOT NULL DEFAULT 0,
  `session` int(2) NOT NULL DEFAULT 0,
  `cmn_terms` varchar(5) NOT NULL DEFAULT '0',
  `section` int(4) DEFAULT 0,
  `cc_id` int(2) NOT NULL DEFAULT 0,
  `department` int(3) NOT NULL DEFAULT 0,
  `course_id` int(11) NOT NULL,
  `upload_file` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `stu_updated_date` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_info`
--

CREATE TABLE `attendance_info` (
  `id` int(5) NOT NULL,
  `component_2` int(11) NOT NULL,
  `component_3` int(11) NOT NULL,
  `component_2_%` int(11) NOT NULL,
  `component_3_%` int(11) NOT NULL,
  `u_id` varchar(20) DEFAULT '0',
  `attended_class` int(5) NOT NULL DEFAULT 0,
  `attend_remarks` varchar(50) DEFAULT '0',
  `required_percentage` int(10) NOT NULL DEFAULT 0,
  `percent` int(10) NOT NULL,
  `attendance_master_id` int(10) NOT NULL,
  `batch` varchar(100) NOT NULL DEFAULT 'NA',
  `online_attended` int(10) NOT NULL DEFAULT 0,
  `offline_attended` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_info`
--

INSERT INTO `attendance_info` (`id`, `component_2`, `component_3`, `component_2_%`, `component_3_%`, `u_id`, `attended_class`, `attend_remarks`, `required_percentage`, `percent`, `attendance_master_id`, `batch`, `online_attended`, `offline_attended`) VALUES
(1, 1, 0, 100, 0, 'F-2023-1', 1, '0', 0, 100, 1, 'BA-2023-27', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_info_master`
--

CREATE TABLE `attendance_info_master` (
  `id` int(5) NOT NULL,
  `session` int(5) NOT NULL,
  `section` int(5) DEFAULT 0,
  `cmn_terms` varchar(2) NOT NULL,
  `cc_id` int(5) NOT NULL DEFAULT 0,
  `ge_id` int(2) DEFAULT 0,
  `department_id` int(5) DEFAULT 0,
  `employee_id` varchar(10) DEFAULT '0',
  `department` int(5) DEFAULT NULL,
  `course_id` int(3) DEFAULT 0,
  `component_paper` varchar(10) NOT NULL,
  `effective_date` date NOT NULL,
  `batch` varchar(100) DEFAULT '0',
  `conducted_class` int(5) NOT NULL DEFAULT 0,
  `status` int(2) NOT NULL,
  `degree_id` int(5) NOT NULL,
  `theory` int(10) NOT NULL,
  `practical` int(10) DEFAULT NULL,
  `online` int(10) NOT NULL DEFAULT 0,
  `offline` int(10) NOT NULL DEFAULT 0,
  `academic_year` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_info_master`
--

INSERT INTO `attendance_info_master` (`id`, `session`, `section`, `cmn_terms`, `cc_id`, `ge_id`, `department_id`, `employee_id`, `department`, `course_id`, `component_paper`, `effective_date`, `batch`, `conducted_class`, `status`, `degree_id`, `theory`, `practical`, `online`, `offline`, `academic_year`) VALUES
(1, 1, 0, 't1', 1, 0, NULL, 'EMP-f-110', 1, NULL, '', '2023-08-01', '0', 1, 0, 1, 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `back_grade_allocation_items`
--

CREATE TABLE `back_grade_allocation_items` (
  `grade_allocation_item_id` int(11) NOT NULL,
  `grade_allocation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_id` varchar(100) NOT NULL,
  `grade_value` varchar(50) NOT NULL,
  `number_value` varchar(50) DEFAULT NULL,
  `reval_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `back_grade_allocation_report_items`
--

CREATE TABLE `back_grade_allocation_report_items` (
  `grade_allocation_report_item_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_grades` text DEFAULT NULL,
  `component_weightages` text DEFAULT NULL,
  `grade_point` float DEFAULT NULL,
  `ge_id` int(5) NOT NULL DEFAULT 0,
  `tabl_id` int(20) NOT NULL DEFAULT 0,
  `sort` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `back_selection_items`
--

CREATE TABLE `back_selection_items` (
  `items_id` int(11) NOT NULL,
  `elective_id` int(11) NOT NULL,
  `term_ids` int(11) NOT NULL,
  `elective_name` int(11) NOT NULL,
  `students_id` int(11) NOT NULL,
  `electives` int(11) NOT NULL DEFAULT 0,
  `terms` int(11) NOT NULL,
  `credit_value` float NOT NULL,
  `aecc` int(10) NOT NULL DEFAULT 0,
  `ge_id` int(10) NOT NULL DEFAULT 0,
  `code` varchar(100) DEFAULT NULL,
  `fail_status` tinyint(4) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `exam_month` varchar(50) NOT NULL,
  `publish_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `back_tabulation_report_items`
--

CREATE TABLE `back_tabulation_report_items` (
  `id` int(10) NOT NULL,
  `tabl_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `sgpa` float(4,2) DEFAULT NULL,
  `fail_in_ct_ids` varchar(255) DEFAULT NULL,
  `total_credit_point` float DEFAULT NULL,
  `total_grade_point` float DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `course_id` varchar(255) NOT NULL,
  `grade_point` varchar(255) NOT NULL,
  `publish_date` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `batch_scheduler`
--

CREATE TABLE `batch_scheduler` (
  `batch_schedule_id` int(11) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `term_id` int(11) NOT NULL,
  `day` varchar(50) DEFAULT NULL,
  `class_1` varchar(50) DEFAULT NULL,
  `class_2` varchar(50) DEFAULT NULL,
  `class_3` varchar(50) DEFAULT NULL,
  `class_4` varchar(50) DEFAULT NULL,
  `class_5` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `day_count` int(50) DEFAULT NULL,
  `publish` float(4,1) NOT NULL DEFAULT 0.0,
  `updated_date` varchar(255) NOT NULL,
  `description_1` varchar(255) DEFAULT NULL,
  `description_2` varchar(255) DEFAULT NULL,
  `description_3` varchar(255) DEFAULT NULL,
  `description_4` varchar(255) DEFAULT NULL,
  `description_5` varchar(255) DEFAULT NULL,
  `section` int(6) NOT NULL,
  `time_1` varchar(50) DEFAULT NULL,
  `time_2` varchar(50) DEFAULT NULL,
  `time_3` varchar(50) DEFAULT NULL,
  `room_1` varchar(50) DEFAULT NULL,
  `room_2` varchar(50) DEFAULT NULL,
  `room_3` varchar(50) DEFAULT NULL,
  `class_6` varchar(50) DEFAULT NULL,
  `description_6` varchar(50) DEFAULT NULL,
  `time_4` varchar(50) DEFAULT NULL,
  `time_5` varchar(50) DEFAULT NULL,
  `time_6` varchar(50) DEFAULT NULL,
  `room_4` varchar(50) DEFAULT NULL,
  `room_5` varchar(50) DEFAULT NULL,
  `room_6` varchar(50) DEFAULT NULL,
  `class_7` varchar(50) DEFAULT NULL,
  `class_8` varchar(50) DEFAULT NULL,
  `description_7` varchar(50) DEFAULT NULL,
  `description_8` varchar(50) DEFAULT NULL,
  `time_7` varchar(50) DEFAULT NULL,
  `time_8` varchar(50) DEFAULT NULL,
  `room_7` varchar(50) DEFAULT NULL,
  `room_8` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_allotment`
--

CREATE TABLE `class_allotment` (
  `id` int(11) NOT NULL,
  `class_no` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `alot_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_master`
--

CREATE TABLE `class_master` (
  `class_id` bigint(20) NOT NULL,
  `term_id` int(10) NOT NULL,
  `academic_year_id` int(10) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `class_description` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `hours` int(10) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_master`
--

INSERT INTO `class_master` (`class_id`, `term_id`, `academic_year_id`, `class_name`, `class_description`, `status`, `hours`, `time`) VALUES
(1, 0, 0, 'Class A', '', 0, 30, '10:00 AM'),
(2, 0, 0, 'Class B', '', 0, 30, '10:30 AM'),
(3, 0, 0, 'Class C', '', 0, 30, '11:00 AM'),
(4, 0, 0, 'Class D', '', 0, 30, '11:30 AM'),
(5, 0, 0, 'Class E', '', 0, 30, '12:00 PM'),
(6, 0, 0, 'Class F', '', 0, 30, '12:30 PM'),
(7, 0, 0, 'Class G', '', 0, 30, '1:00 PM'),
(8, 0, 0, 'Class H', '', 0, 30, '01:30 PM');

-- --------------------------------------------------------

--
-- Table structure for table `componentmaster`
--

CREATE TABLE `componentmaster` (
  `id` int(10) NOT NULL,
  `component` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `componentmaster`
--

INSERT INTO `componentmaster` (`id`, `component`, `status`) VALUES
(1, 'CIA', 1),
(2, 'ESE(T)', 0),
(3, 'ESE(P)', 0);

-- --------------------------------------------------------

--
-- Table structure for table `component_grades`
--

CREATE TABLE `component_grades` (
  `component_grade_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `weightage` float NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `component_grade_items`
--

CREATE TABLE `component_grade_items` (
  `component_grade_item_id` int(11) NOT NULL,
  `component_grade_id` int(11) NOT NULL,
  `letter_grade` varchar(15) NOT NULL,
  `number_grade` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `configure_selection_process`
--

CREATE TABLE `configure_selection_process` (
  `id` int(10) NOT NULL,
  `selection_id` varchar(100) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `selection_process` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `from_date` varchar(100) NOT NULL,
  `to_date` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contribution`
--

CREATE TABLE `contribution` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `contri_amt` varchar(100) NOT NULL,
  `mmp_txn` varchar(100) NOT NULL,
  `mer_txn` varchar(100) NOT NULL,
  `bank_txn` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `prod` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `f_code` varchar(10) NOT NULL,
  `clientcode` varchar(20) NOT NULL,
  `merchant_id` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `pay_mode` varchar(20) NOT NULL,
  `create_date` date NOT NULL,
  `pan_card` varchar(255) NOT NULL,
  `adhar_doc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `core_addon_master`
--

CREATE TABLE `core_addon_master` (
  `ccl_id` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_code` varchar(15) DEFAULT NULL,
  `addon_course_list` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL COMMENT 'if credit is not given sgpa not show in tr',
  `re_credit` float NOT NULL,
  `status` tinyint(4) NOT NULL,
  `count_id` tinyint(4) NOT NULL,
  `degree_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `core_course_master`
--

CREATE TABLE `core_course_master` (
  `ccl_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `term_id` varchar(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_code` varchar(15) DEFAULT NULL,
  `cc_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL COMMENT 'if credit is not given sgpa not show in tr',
  `re_credit` float NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ge_id` int(10) NOT NULL DEFAULT 0,
  `count_id` tinyint(4) NOT NULL,
  `degree_id` int(5) NOT NULL,
  `cmn_terms` varchar(2) DEFAULT NULL,
  `ct_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `core_course_master`
--

INSERT INTO `core_course_master` (`ccl_id`, `academic_year_id`, `term_id`, `course_id`, `course_code`, `cc_id`, `credit_id`, `re_credit`, `status`, `ge_id`, `count_id`, `degree_id`, `cmn_terms`, `ct_id`) VALUES
(1, 1, '1', 1, NULL, 1, 1, 14, 0, 0, 0, 1, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `courses_evaluation_components_items`
--

CREATE TABLE `courses_evaluation_components_items` (
  `cr_eci_id` int(11) NOT NULL,
  `el_ec_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `course_type` int(11) NOT NULL,
  `component_name` varchar(50) NOT NULL,
  `weightage` float NOT NULL,
  `remaining_weightage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_faculty_allotment_items`
--

CREATE TABLE `courses_faculty_allotment_items` (
  `courses_faculty_allotment_item_id` int(11) NOT NULL,
  `faculty_allotment_id` int(11) NOT NULL,
  `course_type` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `cc_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `credit_value` float NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_grade_allocation_report_items`
--

CREATE TABLE `courses_grade_allocation_report_items` (
  `course_grade_report_item_id` int(11) NOT NULL,
  `elective_grade_report_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_grades` text NOT NULL,
  `component_ids` text NOT NULL,
  `component_weightages` text NOT NULL,
  `grade_point` float NOT NULL,
  `ge_id` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_category_master`
--

CREATE TABLE `course_category_master` (
  `cc_id` int(11) NOT NULL,
  `cc_name` varchar(200) NOT NULL,
  `cc_description` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `degree_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_category_master`
--

INSERT INTO `course_category_master` (`cc_id`, `cc_name`, `cc_description`, `status`, `degree_id`) VALUES
(1, 'Major', 'Major UG', 0, 1),
(2, 'Minor', 'Minor', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_fee`
--

CREATE TABLE `course_fee` (
  `id` int(10) NOT NULL,
  `academic_year` int(2) DEFAULT NULL,
  `session_id` int(5) NOT NULL DEFAULT 0,
  `cmn_terms` varchar(10) NOT NULL DEFAULT '0',
  `degree_id` int(5) NOT NULL DEFAULT 0,
  `department` int(5) NOT NULL DEFAULT 0,
  `feeForm_start_date` date NOT NULL,
  `feeForm_end_date` date NOT NULL,
  `feeForm_extended_date` date NOT NULL,
  `examFee` varchar(10) NOT NULL DEFAULT '0',
  `fineFee` varchar(10) NOT NULL DEFAULT '0',
  `status` int(5) NOT NULL DEFAULT 0,
  `product_id` varchar(200) DEFAULT NULL,
  `account_no` varchar(50) NOT NULL,
  `exam_type` int(11) NOT NULL,
  `perday` int(11) NOT NULL,
  `exam_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_feed`
--

CREATE TABLE `course_feed` (
  `id` int(11) NOT NULL,
  `course` varchar(50) NOT NULL,
  `feed` varchar(50) DEFAULT NULL,
  `instructor` varchar(50) NOT NULL,
  `batch` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `question_no_c` varchar(255) DEFAULT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_grade_after_penalties`
--

CREATE TABLE `course_grade_after_penalties` (
  `id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_grade_after_penalties_items`
--

CREATE TABLE `course_grade_after_penalties_items` (
  `item_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `academic_courses` text NOT NULL,
  `academic_credits` text NOT NULL,
  `academic_grades` text NOT NULL,
  `elective_ids` text DEFAULT NULL,
  `academic_electives` text DEFAULT NULL,
  `final_grade` decimal(4,2) DEFAULT NULL,
  `cgpa` decimal(4,2) DEFAULT NULL,
  `fee_percent` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_master`
--

CREATE TABLE `course_master` (
  `course_id` int(11) NOT NULL,
  `course_category_id` int(11) NOT NULL,
  `course_code` varchar(30) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_description` varchar(400) NOT NULL,
  `ct_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_master`
--

INSERT INTO `course_master` (`course_id`, `course_category_id`, `course_code`, `course_name`, `course_description`, `ct_id`, `status`) VALUES
(1, 1, 'H101', 'H', 'H', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_master_match`
--

CREATE TABLE `course_master_match` (
  `course_id` int(11) NOT NULL,
  `course_category_id` int(11) NOT NULL,
  `course_code` varchar(30) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_description` varchar(400) NOT NULL,
  `ct_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_report`
--

CREATE TABLE `course_report` (
  `id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `batch_id` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course_count` int(11) NOT NULL,
  `section` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_type_master`
--

CREATE TABLE `course_type_master` (
  `ct_id` int(11) NOT NULL,
  `ct_name` varchar(100) NOT NULL,
  `ct_description` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `degree_id` int(5) NOT NULL,
  `sort_order` tinyint(4) NOT NULL DEFAULT 1,
  `course_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_type_master`
--

INSERT INTO `course_type_master` (`ct_id`, `ct_name`, `ct_description`, `status`, `degree_id`, `sort_order`, `course_category`) VALUES
(1, 'M1', 'Major 1', 0, 1, 1, 1),
(2, 'M2', 'Major 2', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_wise_grades`
--

CREATE TABLE `course_wise_grades` (
  `id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_wise_grade_items`
--

CREATE TABLE `course_wise_grade_items` (
  `item_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `academic_courses` text NOT NULL,
  `academic_credits` text NOT NULL,
  `academic_grades` text NOT NULL,
  `academic_electives` text NOT NULL,
  `elective_values` text NOT NULL,
  `total_grade` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_wise_penalties`
--

CREATE TABLE `course_wise_penalties` (
  `id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_wise_penalties`
--

INSERT INTO `course_wise_penalties` (`id`, `academic_id`, `term_id`, `status`) VALUES
(0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_wise_penalties_items`
--

CREATE TABLE `course_wise_penalties_items` (
  `item_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `absence` text NOT NULL,
  `academic_courses` text NOT NULL,
  `academic_credits` text NOT NULL,
  `academic_electives` text NOT NULL,
  `academic_electives_ids` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credit_master`
--

CREATE TABLE `credit_master` (
  `credit_id` int(11) NOT NULL,
  `credit_value` float NOT NULL,
  `credit_name` varchar(100) NOT NULL,
  `credit_type` varchar(100) NOT NULL,
  `credit_desc` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_master`
--

INSERT INTO `credit_master` (`credit_id`, `credit_value`, `credit_name`, `credit_type`, `credit_desc`, `status`) VALUES
(1, 6, 'Major', '1', 'Major', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cumulative_marks`
--

CREATE TABLE `cumulative_marks` (
  `id` int(11) NOT NULL,
  `stu_id` varchar(150) NOT NULL,
  `term_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `course_id` varchar(150) NOT NULL,
  `number_value` varchar(50) NOT NULL,
  `total_marks` varchar(150) NOT NULL,
  `credit` varchar(150) NOT NULL,
  `grade_letter` varchar(100) DEFAULT NULL,
  `grade_point` varchar(50) NOT NULL,
  `credit_point` varchar(50) NOT NULL,
  `total_grade_point` varchar(50) NOT NULL,
  `tabl_id` int(11) NOT NULL,
  `sgpa` double(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `daily_attendance_info`
--

CREATE TABLE `daily_attendance_info` (
  `id` int(5) NOT NULL,
  `attend_status` int(2) DEFAULT NULL,
  `f_id` varchar(25) NOT NULL,
  `batch` varchar(25) DEFAULT NULL,
  `master_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_attendance_info`
--

INSERT INTO `daily_attendance_info` (`id`, `attend_status`, `f_id`, `batch`, `master_id`) VALUES
(1, 1, 'F-2023-1', 'BA-2023-27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `daily_attendance_master`
--

CREATE TABLE `daily_attendance_master` (
  `id` int(2) NOT NULL,
  `academic_year` int(2) DEFAULT NULL,
  `session` int(5) NOT NULL,
  `section` int(5) DEFAULT 0,
  `cmn_terms` varchar(5) NOT NULL,
  `cc_id` int(5) NOT NULL,
  `ge_id` int(5) NOT NULL,
  `department_id` varchar(25) DEFAULT NULL,
  `employee_id` varchar(28) NOT NULL,
  `department` int(2) DEFAULT 0,
  `course_id` int(5) DEFAULT 0,
  `effective_date` date NOT NULL,
  `degree_id` int(2) NOT NULL,
  `status` int(2) NOT NULL,
  `teacher_dept` int(10) DEFAULT NULL,
  `period` varchar(10) DEFAULT NULL,
  `submit_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daily_attendance_master`
--

INSERT INTO `daily_attendance_master` (`id`, `academic_year`, `session`, `section`, `cmn_terms`, `cc_id`, `ge_id`, `department_id`, `employee_id`, `department`, `course_id`, `effective_date`, `degree_id`, `status`, `teacher_dept`, `period`, `submit_date`) VALUES
(1, 1, 1, 0, 't1', 1, 0, NULL, 'EMP-f-110', 1, NULL, '2023-08-21', 1, 0, 1, 'p1', '2023-08-21');

-- --------------------------------------------------------

--
-- Table structure for table `daily_attendance_new`
--

CREATE TABLE `daily_attendance_new` (
  `id` int(5) NOT NULL,
  `attend_status` int(2) DEFAULT NULL,
  `f_id` varchar(25) NOT NULL,
  `batch` varchar(25) DEFAULT NULL,
  `master_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `datatable_master`
--

CREATE TABLE `datatable_master` (
  `id` int(10) NOT NULL,
  `fields` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `declared_terms`
--

CREATE TABLE `declared_terms` (
  `id` int(11) NOT NULL,
  `term_des` varchar(20) NOT NULL,
  `term_name` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `declared_terms`
--

INSERT INTO `declared_terms` (`id`, `term_des`, `term_name`, `status`) VALUES
(1, 't1', 'Sem-1', 0),
(2, 't2', 'Sem-2', 0),
(3, 't3', 'Sem-3', 0),
(4, 't4', 'Sem-4', 0),
(5, 't5', 'Sem-5', 0),
(6, 't6', 'Sem-6', 0),
(7, 't7', 'Sem-7', 0),
(8, 't8', 'Sem-8', 0);

-- --------------------------------------------------------

--
-- Table structure for table `degree_info`
--

CREATE TABLE `degree_info` (
  `id` int(10) NOT NULL,
  `degree` varchar(20) NOT NULL,
  `created_date` date NOT NULL DEFAULT '0000-00-00',
  `last_modified_date` date NOT NULL DEFAULT '0000-00-00',
  `status` int(2) NOT NULL DEFAULT 0,
  `active` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `degree_info`
--

INSERT INTO `degree_info` (`id`, `degree`, `created_date`, `last_modified_date`, `status`, `active`) VALUES
(1, 'UG', '0000-00-00', '2023-05-17', 0, 0),
(2, 'PG', '2023-05-17', '0000-00-00', 0, 0),
(3, 'MCA', '2023-05-17', '0000-00-00', 0, 0),
(4, 'B.ed', '2023-05-17', '0000-00-00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `deleted_grade_allocation_items`
--

CREATE TABLE `deleted_grade_allocation_items` (
  `grade_allocation_item_id` int(11) NOT NULL,
  `grade_allocation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_id` varchar(100) NOT NULL,
  `grade_value` varchar(50) NOT NULL,
  `number_value` varchar(50) DEFAULT NULL,
  `update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `publish_date` date NOT NULL DEFAULT '0000-00-00',
  `flag` char(1) NOT NULL,
  `reval_status` char(1) NOT NULL DEFAULT '0',
  `obtained_marks` int(4) NOT NULL DEFAULT 0,
  `total_marks` int(4) NOT NULL DEFAULT 0,
  `percent` float(4,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `department` varchar(50) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `department_type` varchar(15) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `last_modified_date` date NOT NULL,
  `created_date` date NOT NULL,
  `degree_id` int(5) NOT NULL,
  `short_code` varchar(3) NOT NULL,
  `debt_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department`, `description`, `department_type`, `status`, `last_modified_date`, `created_date`, `degree_id`, `short_code`, `debt_group`) VALUES
(1, 'MA', 'Test', '1', 0, '0000-00-00', '2023-08-25', 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `department_type`
--

CREATE TABLE `department_type` (
  `id` int(3) NOT NULL,
  `department_type` varchar(50) NOT NULL,
  `degree_id` int(3) NOT NULL,
  `session` varchar(10) NOT NULL,
  `session_id` int(1) NOT NULL,
  `account_name` varchar(225) NOT NULL,
  `account_no` varchar(25) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `status` int(1) NOT NULL,
  `dept-group` int(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department_type`
--

INSERT INTO `department_type` (`id`, `department_type`, `degree_id`, `session`, `session_id`, `account_name`, `account_no`, `amount`, `status`, `dept-group`) VALUES
(1, 'BA', 1, '', 0, '', '', '', 0, 0),
(2, 'BSC', 1, '', 0, '', '', '', 0, 0),
(3, 'BCom', 1, '', 0, '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `direct_final_grade_dmi`
--

CREATE TABLE `direct_final_grade_dmi` (
  `id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `final_grade` decimal(4,2) NOT NULL,
  `credit_value` decimal(4,2) NOT NULL,
  `grade_credit_multiplied` decimal(4,2) NOT NULL,
  `deleted` tinyint(1) DEFAULT 0,
  `added_on` datetime NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `added_by_ip` varchar(40) DEFAULT NULL,
  `updated_by_ip` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `documents_for_admission`
--

CREATE TABLE `documents_for_admission` (
  `id` int(4) NOT NULL,
  `application_no` varchar(100) NOT NULL,
  `degree_id` int(1) NOT NULL,
  `marksheet` varchar(225) DEFAULT NULL,
  `f_year` varchar(225) DEFAULT NULL,
  `s_year` varchar(225) DEFAULT NULL,
  `t_year` varchar(225) DEFAULT NULL,
  `slc_cert` varchar(225) DEFAULT NULL,
  `char_cert` varchar(225) DEFAULT NULL,
  `caste_cert` varchar(225) DEFAULT NULL,
  `bapt_cert` varchar(225) DEFAULT NULL,
  `undertaking_cert` varchar(225) DEFAULT NULL,
  `submit_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL,
  `department` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dtablesetting`
--

CREATE TABLE `dtablesetting` (
  `id` bigint(20) NOT NULL,
  `url` text NOT NULL,
  `settings` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `duration`
--

CREATE TABLE `duration` (
  `id` int(11) NOT NULL,
  `duration_from` time DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` date NOT NULL,
  `last_modified_date` date NOT NULL,
  `duration_to` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_evaluation_components_grade_master`
--

CREATE TABLE `electives_evaluation_components_grade_master` (
  `elective_component_grade_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `course_type` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `elective_component_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_evaluation_components_grade_master_items`
--

CREATE TABLE `electives_evaluation_components_grade_master_items` (
  `elective_component_grade_item_id` int(11) NOT NULL,
  `elective_component_grade_id` int(11) NOT NULL,
  `letter_grade` varchar(20) NOT NULL,
  `number_grade` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_evaluation_components_items`
--

CREATE TABLE `electives_evaluation_components_items` (
  `el_eci_id` int(11) NOT NULL,
  `el_ec_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `elective_id` int(11) NOT NULL,
  `course_type` int(11) NOT NULL,
  `component_name` varchar(40) NOT NULL,
  `weightage` float NOT NULL,
  `remaining_weightage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_evaluation_components_master`
--

CREATE TABLE `electives_evaluation_components_master` (
  `el_ec_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_faculty_allotment`
--

CREATE TABLE `electives_faculty_allotment` (
  `faculty_allotment_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_faculty_allotment_items`
--

CREATE TABLE `electives_faculty_allotment_items` (
  `electives_faculty_item_id` int(11) NOT NULL,
  `faculty_allotment_id` int(11) NOT NULL,
  `course_type` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `elective_id` int(11) NOT NULL,
  `credit_value` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_grade_allocation`
--

CREATE TABLE `electives_grade_allocation` (
  `elective_grade_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `course_type` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `elective_component_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_grade_allocation_items`
--

CREATE TABLE `electives_grade_allocation_items` (
  `electives_grade_allocation_item_id` int(11) NOT NULL,
  `elective_grade_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_id` text NOT NULL,
  `elective_component_id` text NOT NULL,
  `grade_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_grade_allocation_report`
--

CREATE TABLE `electives_grade_allocation_report` (
  `elective_grade_report_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `degree_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electives_grade_allocation_report_items`
--

CREATE TABLE `electives_grade_allocation_report_items` (
  `elective_grade_report_item_id` int(11) NOT NULL,
  `elective_grade_report_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `elective_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_grades` text NOT NULL,
  `component_ids` text NOT NULL,
  `component_weightages` text NOT NULL,
  `grade_point` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `elective_course_learning_master`
--

CREATE TABLE `elective_course_learning_master` (
  `ecrl_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_category_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `total_no_of_credits` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_addon_allocation`
--

CREATE TABLE `employee_addon_allocation` (
  `id` int(11) NOT NULL,
  `course_category` varchar(50) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `faculty_id` varchar(300) DEFAULT NULL,
  `visiting_faculty_id` varchar(300) DEFAULT NULL,
  `remarks` text NOT NULL,
  `course_code` varchar(15) NOT NULL DEFAULT '0',
  `addon_course_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_allocation_items_master`
--

CREATE TABLE `employee_allocation_items_master` (
  `ead_id` int(11) NOT NULL,
  `ea_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `cc_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `faculty_id` varchar(300) DEFAULT NULL,
  `visiting_faculty_id` varchar(300) DEFAULT NULL,
  `remarks` text NOT NULL,
  `course_code` varchar(15) NOT NULL DEFAULT '0',
  `department` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_allocation_items_master`
--

INSERT INTO `employee_allocation_items_master` (`ead_id`, `ea_id`, `term_id`, `cc_id`, `course_id`, `credit_id`, `department_id`, `employee_id`, `faculty_id`, `visiting_faculty_id`, `remarks`, `course_code`, `department`) VALUES
(2, 1, 1, 1, 1, 1, 1, 'EMP-f-170', 'EMP-F-004', 'EMP-F-002,EMP-F-003,EMP-F-001', '', 'H101', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee_allotment_master`
--

CREATE TABLE `employee_allotment_master` (
  `ea_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `hod_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_allotment_master`
--

INSERT INTO `employee_allotment_master` (`ea_id`, `academic_year_id`, `term_id`, `status`, `hod_id`) VALUES
(1, 1, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `empl_dept`
--

CREATE TABLE `empl_dept` (
  `id` int(2) NOT NULL,
  `empl_id` varchar(225) NOT NULL,
  `dept_id` varchar(255) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `empl_dept`
--

INSERT INTO `empl_dept` (`id`, `empl_id`, `dept_id`, `status`) VALUES
(1, 'EMP-f-110', '1', 0),
(2, 'EMP-f-110', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `entrance_exam_schedule`
--

CREATE TABLE `entrance_exam_schedule` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `feeForm_start_date` date NOT NULL,
  `feeForm_end_date` date NOT NULL,
  `exam_date` date NOT NULL,
  `examFee` varchar(25) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `account_no` varchar(50) NOT NULL,
  `examtime_start` varchar(50) NOT NULL,
  `examtime_end` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `allow_reg` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `erp_admin`
--

CREATE TABLE `erp_admin` (
  `admin_id` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `admin_user_name` varchar(60) NOT NULL DEFAULT '',
  `admin_user_email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL DEFAULT '',
  `user_type` varchar(100) NOT NULL DEFAULT '',
  `role_id` int(11) NOT NULL DEFAULT 1,
  `unit_id` int(11) NOT NULL,
  `ipaddress` varchar(128) NOT NULL DEFAULT '',
  `created_date_time` datetime NOT NULL,
  `last_visit_date` datetime DEFAULT NULL,
  `status` int(15) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `erp_alumni_table`
--

CREATE TABLE `erp_alumni_table` (
  `part_id` int(11) NOT NULL,
  `al_email_id` varchar(255) NOT NULL,
  `al_contact_no` varchar(255) NOT NULL,
  `al_current_location` varchar(255) NOT NULL,
  `al_address` text NOT NULL,
  `al_current_position` varchar(255) NOT NULL,
  `al_leave_a message` varchar(255) NOT NULL,
  `al_organisation` varchar(255) NOT NULL,
  `al_status` tinyint(4) NOT NULL DEFAULT 0,
  `al_url` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `display_phone` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `erp_elective_selection`
--

CREATE TABLE `erp_elective_selection` (
  `elective_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `erp_elective_selection_items`
--

CREATE TABLE `erp_elective_selection_items` (
  `items_id` int(11) NOT NULL,
  `elective_id` int(11) NOT NULL,
  `term_ids` int(11) NOT NULL,
  `elective_name` int(11) NOT NULL,
  `students_id` int(11) NOT NULL,
  `electives` int(11) NOT NULL DEFAULT 0,
  `terms` int(11) NOT NULL,
  `credit_value` float NOT NULL,
  `aecc` int(10) NOT NULL DEFAULT 0,
  `ge_id` int(10) NOT NULL DEFAULT 0,
  `code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `erp_fee_category_master`
--

CREATE TABLE `erp_fee_category_master` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `fund_type` tinyint(4) NOT NULL,
  `degree_id` int(10) NOT NULL,
  `session_id` int(10) NOT NULL DEFAULT 0,
  `dept_id` int(11) NOT NULL,
  `degree_r` int(11) NOT NULL,
  `cat_r` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erp_fee_category_master`
--

INSERT INTO `erp_fee_category_master` (`category_id`, `category_name`, `status`, `fund_type`, `degree_id`, `session_id`, `dept_id`, `degree_r`, `cat_r`) VALUES
(1, 'General fund', 0, 1, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_fee_heads_items`
--

CREATE TABLE `erp_fee_heads_items` (
  `items_id` int(11) NOT NULL,
  `feehead_id` int(11) NOT NULL,
  `feehead_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `erp_fee_heads_master`
--

CREATE TABLE `erp_fee_heads_master` (
  `feehead_id` int(11) NOT NULL,
  `feecategory_id` int(11) NOT NULL,
  `feehead_name` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `degree_id` int(10) NOT NULL,
  `session_id` int(11) NOT NULL DEFAULT 0,
  `dept_id` int(11) NOT NULL,
  `head_r` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erp_fee_heads_master`
--

INSERT INTO `erp_fee_heads_master` (`feehead_id`, `feecategory_id`, `feehead_name`, `status`, `degree_id`, `session_id`, `dept_id`, `head_r`) VALUES
(1, 1, 'H1', 0, 1, 1, 1, 0),
(2, 1, 'H2', 0, 1, 1, 1, 0),
(3, 1, 'H3', 0, 1, 1, 1, 0),
(4, 1, 'H4', 0, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_fee_structure_items`
--

CREATE TABLE `erp_fee_structure_items` (
  `items_id` int(11) NOT NULL,
  `structure_id` int(11) NOT NULL,
  `t1_date` varchar(20) NOT NULL,
  `t2_date` varchar(20) NOT NULL,
  `t3_date` varchar(20) NOT NULL,
  `t4_date` varchar(20) NOT NULL,
  `t5_date` varchar(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `fee_heads_id` int(11) NOT NULL,
  `term1_val` float NOT NULL,
  `term2_val` float NOT NULL,
  `term3_val` float NOT NULL,
  `term4_val` float NOT NULL,
  `term5_val` float NOT NULL,
  `feeheads_total` float DEFAULT NULL,
  `term1_cat_total` float NOT NULL,
  `term2_cat_total` float NOT NULL,
  `term3_cat_total` float NOT NULL,
  `term4_cat_total` float NOT NULL,
  `term5_cat_total` float NOT NULL,
  `cat_row_total` float NOT NULL,
  `grand_term1_result` float DEFAULT 0,
  `grand_term2_result` float DEFAULT 0,
  `grand_term3_result` float DEFAULT 0,
  `grand_term4_result` float DEFAULT 0,
  `grand_term5_result` float DEFAULT 0,
  `total_grand_value` float NOT NULL,
  `t6_date` varchar(100) NOT NULL,
  `term6_val` float NOT NULL,
  `term6_cat_total` float NOT NULL,
  `grand_term6_result` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erp_fee_structure_items`
--

INSERT INTO `erp_fee_structure_items` (`items_id`, `structure_id`, `t1_date`, `t2_date`, `t3_date`, `t4_date`, `t5_date`, `category_id`, `fee_heads_id`, `term1_val`, `term2_val`, `term3_val`, `term4_val`, `term5_val`, `feeheads_total`, `term1_cat_total`, `term2_cat_total`, `term3_cat_total`, `term4_cat_total`, `term5_cat_total`, `cat_row_total`, `grand_term1_result`, `grand_term2_result`, `grand_term3_result`, `grand_term4_result`, `grand_term5_result`, `total_grand_value`, `t6_date`, `term6_val`, `term6_cat_total`, `grand_term6_result`) VALUES
(3, 3, '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 2300, 1800, 0, 0, 0, 4100, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_fee_structure_master`
--

CREATE TABLE `erp_fee_structure_master` (
  `structure_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `department` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erp_fee_structure_master`
--

INSERT INTO `erp_fee_structure_master` (`structure_id`, `academic_id`, `status`, `department`) VALUES
(3, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_fee_structure_term_items`
--

CREATE TABLE `erp_fee_structure_term_items` (
  `term_items_id` int(11) NOT NULL,
  `structure_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `fee_heads_id` int(11) NOT NULL,
  `terms_id` varchar(11) NOT NULL,
  `fees` float DEFAULT NULL,
  `feeheads_total` float DEFAULT 0,
  `cat_row_total` float DEFAULT NULL,
  `terms` tinyint(4) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erp_fee_structure_term_items`
--

INSERT INTO `erp_fee_structure_term_items` (`term_items_id`, `structure_id`, `category_id`, `fee_heads_id`, `terms_id`, `fees`, `feeheads_total`, `cat_row_total`, `terms`, `status`) VALUES
(8, 3, 1, 1, 't1', 200, 300, 4100, 1, 0),
(9, 3, 1, 1, 't2', 100, 300, 4100, 2, 0),
(10, 3, 1, 2, 't1', 400, 600, 4100, 1, 0),
(11, 3, 1, 2, 't2', 200, 600, 4100, 2, 0),
(12, 3, 1, 3, 't1', 1200, 1500, 4100, 1, 0),
(13, 3, 1, 3, 't2', 300, 1500, 4100, 2, 0),
(14, 3, 1, 4, 't1', 500, 1700, 4100, 1, 0),
(15, 3, 1, 4, 't2', 1200, 1700, 4100, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `erp_student_information`
--

CREATE TABLE `erp_student_information` (
  `student_id` int(11) NOT NULL,
  `stu_fname` varchar(100) NOT NULL,
  `stu_lname` varchar(100) NOT NULL,
  `gender` int(3) NOT NULL,
  `stu_mobileno` varchar(12) NOT NULL,
  `stu_email_id` varchar(120) NOT NULL,
  `stu_dob` varchar(100) NOT NULL,
  `present_addr` text NOT NULL,
  `premanent_addr` text NOT NULL,
  `stu_status` int(11) NOT NULL COMMENT '1-Active,2-deactive,3-tc,4-col Action not Allow,5-non col action not Allowed',
  `effective_date` varchar(20) NOT NULL,
  `adv_col` text NOT NULL,
  `father_fname` varchar(100) NOT NULL,
  `father_lname` varchar(100) NOT NULL,
  `father_mobileno` varchar(12) NOT NULL,
  `mother_fname` varchar(100) NOT NULL,
  `mother_lname` varchar(100) NOT NULL,
  `mother_mobileno` varchar(12) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `year_id` int(1) DEFAULT NULL,
  `dept_type` int(1) DEFAULT NULL,
  `terms_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `stu_id` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `filename` text NOT NULL,
  `passing_year` char(4) DEFAULT NULL,
  `passing_status` tinyint(4) DEFAULT NULL,
  `blood_group` varchar(3) DEFAULT NULL,
  `reg_no` varchar(100) NOT NULL DEFAULT '0000',
  `exam_roll` varchar(100) NOT NULL DEFAULT '0000',
  `roll_no` int(10) NOT NULL DEFAULT 0,
  `leaving_sem` varchar(5) NOT NULL,
  `stu_aadhar` varchar(15) NOT NULL,
  `stu_nationality` varchar(20) NOT NULL DEFAULT 'Indian',
  `adm_sem` varchar(15) NOT NULL,
  `stu_doA` varchar(25) NOT NULL,
  `stream` int(2) NOT NULL,
  `tc_number` int(2) NOT NULL DEFAULT 0,
  `tc_status` tinyint(1) NOT NULL DEFAULT 0,
  `name_of_university_exam` varchar(250) NOT NULL,
  `name_of_exam` varchar(100) NOT NULL,
  `result_of_exam` varchar(100) NOT NULL,
  `is_promoted` tinyint(1) DEFAULT 0,
  `is_course_completed` tinyint(1) DEFAULT 0,
  `is_fee_paid` tinyint(1) DEFAULT 0,
  `session_for_cert` text DEFAULT NULL,
  `session_for_tc` varchar(255) DEFAULT 'NULL',
  `session_for_char` varchar(255) DEFAULT 'NULL',
  `earned_credit` int(11) NOT NULL DEFAULT 0,
  `semester_fee_waiver` tinyint(2) NOT NULL DEFAULT 0,
  `col_exam_fee` tinyint(2) NOT NULL DEFAULT 0,
  `non_col_exam_fee_waive` tinyint(2) NOT NULL DEFAULT 0,
  `stu_caste` varchar(50) DEFAULT NULL,
  `is_migration` int(11) NOT NULL DEFAULT 0,
  `cast_category` varchar(255) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL,
  `last_exam_year_passing` int(11) DEFAULT NULL,
  `place_of_exam` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `religion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `erp_student_information`
--

INSERT INTO `erp_student_information` (`student_id`, `stu_fname`, `stu_lname`, `gender`, `stu_mobileno`, `stu_email_id`, `stu_dob`, `present_addr`, `premanent_addr`, `stu_status`, `effective_date`, `adv_col`, `father_fname`, `father_lname`, `father_mobileno`, `mother_fname`, `mother_lname`, `mother_mobileno`, `academic_id`, `year_id`, `dept_type`, `terms_id`, `year`, `stu_id`, `status`, `filename`, `passing_year`, `passing_status`, `blood_group`, `reg_no`, `exam_roll`, `roll_no`, `leaving_sem`, `stu_aadhar`, `stu_nationality`, `adm_sem`, `stu_doA`, `stream`, `tc_number`, `tc_status`, `name_of_university_exam`, `name_of_exam`, `result_of_exam`, `is_promoted`, `is_course_completed`, `is_fee_paid`, `session_for_cert`, `session_for_tc`, `session_for_char`, `earned_credit`, `semester_fee_waiver`, `col_exam_fee`, `non_col_exam_fee_waive`, `stu_caste`, `is_migration`, `cast_category`, `institution`, `university`, `last_exam_year_passing`, `place_of_exam`, `state`, `religion`) VALUES
(1, 'raushan', '', 1, '9874563210', 'arya@gmail.com', '01/01/2000', 'fdes', 'gfgh', 1, '', '', 'rddd', '', '0321456987', 'sater', '', '', 1, 1, 2, 0, 0, 'F-2023-1', 0, '', '', 0, '', 'reg002', '', 32, 't1', '987456321023', 'indian', 't1', '', 0, 0, 0, '', '', '', 1, 1, 1, NULL, '', '', 0, 0, 0, 0, 'tezxf', 0, 'r', 'fgd', 'BIHAR', 2018, 'patna', 'Bihar', 'hindu');

-- --------------------------------------------------------

--
-- Table structure for table `erp_student_information_20_03_2023`
--

CREATE TABLE `erp_student_information_20_03_2023` (
  `student_id` int(11) NOT NULL,
  `stu_fname` varchar(100) NOT NULL,
  `stu_lname` varchar(100) NOT NULL,
  `gender` int(3) NOT NULL,
  `stu_mobileno` varchar(12) NOT NULL,
  `stu_email_id` varchar(120) NOT NULL,
  `stu_dob` varchar(100) NOT NULL,
  `present_addr` text NOT NULL,
  `premanent_addr` text NOT NULL,
  `stu_status` int(11) NOT NULL COMMENT '1-Active,2-deactive,3-tc,4-col Action not Allow,5-non col action not Allowed',
  `effective_date` varchar(20) NOT NULL,
  `adv_col` text NOT NULL,
  `father_fname` varchar(100) NOT NULL,
  `father_lname` varchar(100) NOT NULL,
  `father_mobileno` varchar(12) NOT NULL,
  `mother_fname` varchar(100) NOT NULL,
  `mother_lname` varchar(100) NOT NULL,
  `mother_mobileno` varchar(12) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `year_id` int(1) DEFAULT NULL,
  `dept_type` int(1) DEFAULT NULL,
  `terms_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `stu_id` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `filename` text NOT NULL,
  `passing_year` char(4) DEFAULT NULL,
  `passing_status` tinyint(4) DEFAULT NULL,
  `blood_group` varchar(3) DEFAULT NULL,
  `reg_no` varchar(100) NOT NULL DEFAULT '0000',
  `exam_roll` varchar(100) NOT NULL DEFAULT '0000',
  `roll_no` int(10) NOT NULL DEFAULT 0,
  `leaving_sem` varchar(5) NOT NULL,
  `stu_aadhar` varchar(15) NOT NULL,
  `stu_nationality` varchar(20) NOT NULL DEFAULT 'Indian',
  `adm_sem` varchar(15) NOT NULL,
  `stu_doA` varchar(25) NOT NULL,
  `stream` int(2) NOT NULL,
  `tc_number` int(2) NOT NULL DEFAULT 0,
  `tc_status` tinyint(1) NOT NULL DEFAULT 0,
  `name_of_university_exam` varchar(250) NOT NULL,
  `name_of_exam` varchar(100) NOT NULL,
  `result_of_exam` varchar(100) NOT NULL,
  `is_promoted` tinyint(1) DEFAULT 0,
  `is_course_completed` tinyint(1) DEFAULT 0,
  `is_fee_paid` tinyint(1) DEFAULT 0,
  `session_for_cert` text DEFAULT NULL,
  `session_for_tc` varchar(255) DEFAULT 'NULL',
  `session_for_char` varchar(255) DEFAULT 'NULL',
  `earned_credit` int(11) NOT NULL DEFAULT 0,
  `semester_fee_waiver` tinyint(2) NOT NULL DEFAULT 0,
  `col_exam_fee` tinyint(2) NOT NULL DEFAULT 0,
  `non_col_exam_fee_waive` tinyint(2) NOT NULL DEFAULT 0,
  `stu_caste` varchar(50) DEFAULT NULL,
  `is_migration` int(11) NOT NULL DEFAULT 0,
  `cast_category` varchar(255) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL,
  `last_exam_year_passing` int(11) DEFAULT NULL,
  `place_of_exam` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `religion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_components_items_master`
--

CREATE TABLE `evaluation_components_items_master` (
  `eci_id` int(11) NOT NULL,
  `ec_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `component_name` varchar(50) NOT NULL,
  `weightage` float NOT NULL,
  `remaining_weightage` float NOT NULL,
  `component_id` int(5) NOT NULL DEFAULT 0,
  `hod_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_components_items_master`
--

INSERT INTO `evaluation_components_items_master` (`eci_id`, `ec_id`, `term_id`, `course_id`, `component_name`, `weightage`, `remaining_weightage`, `component_id`, `hod_id`) VALUES
(1, 1, 0, 1, 'CIA', 40, 60, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_components_master`
--

CREATE TABLE `evaluation_components_master` (
  `ec_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `cc_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `hod_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation_components_master`
--

INSERT INTO `evaluation_components_master` (`ec_id`, `academic_year_id`, `term_id`, `course_id`, `cc_id`, `credit_id`, `department_id`, `employee_id`, `status`, `hod_id`) VALUES
(1, 0, 0, 1, 1, 1, 1, 'EMP-F-001,EMP-F-002,EMP-F-003,EMP-F-004', 0, 'EMP-f-170');

-- --------------------------------------------------------

--
-- Table structure for table `exambatch`
--

CREATE TABLE `exambatch` (
  `id` int(11) NOT NULL,
  `batch` varchar(40) DEFAULT NULL,
  `department` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `last_modified_date` date NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examchecker`
--

CREATE TABLE `examchecker` (
  `id` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `sem` varchar(11) NOT NULL,
  `last_attempt_year` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examination_dates`
--

CREATE TABLE `examination_dates` (
  `id` int(5) NOT NULL,
  `academic_year` int(2) NOT NULL,
  `session` int(2) NOT NULL,
  `academic_id` int(2) NOT NULL,
  `cmn_terms` varchar(5) NOT NULL,
  `exam_type` tinyint(1) NOT NULL,
  `exam_date` date NOT NULL,
  `result_publish_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reval_date` date DEFAULT NULL,
  `ip` varchar(25) NOT NULL,
  `mark_sheet_status` tinyint(1) NOT NULL DEFAULT 1,
  `admit_card_status` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL,
  `stu_mark_sheet_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam_form_submission`
--

CREATE TABLE `exam_form_submission` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `year_exam` varchar(50) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `term_id` varchar(50) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `date_of_birth` varchar(50) NOT NULL,
  `examination_id` varchar(50) NOT NULL,
  `examination_name` varchar(50) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `college_name` varchar(50) NOT NULL,
  `cc_paper_name` varchar(50) DEFAULT NULL,
  `ge_paper_name` varchar(50) DEFAULT NULL,
  `aecc_paper_name` varchar(50) DEFAULT NULL,
  `created_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `payment_status` int(11) NOT NULL DEFAULT 0,
  `u_id` varchar(50) NOT NULL,
  `payment_activation` int(11) NOT NULL,
  `non_collegiate_status` int(11) NOT NULL DEFAULT 0,
  `email` varchar(50) NOT NULL,
  `default_d_time` datetime DEFAULT current_timestamp(),
  `phone` varchar(20) NOT NULL,
  `pay_mode` varchar(25) DEFAULT NULL,
  `exam_month_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedule`
--

CREATE TABLE `exam_schedule` (
  `id` int(5) NOT NULL,
  `session_id` int(5) NOT NULL,
  `cmn_terms` varchar(10) NOT NULL,
  `degree_id` int(5) NOT NULL,
  `cc_id` int(5) NOT NULL,
  `ge_id` int(5) NOT NULL,
  `department_id` int(5) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `department` int(5) NOT NULL,
  `course_id` int(5) NOT NULL,
  `component_paper` varchar(10) NOT NULL,
  `time_from` varchar(10) NOT NULL,
  `time_to` varchar(10) NOT NULL,
  `exam_date` date NOT NULL,
  `status` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_course_grade_aftr_penalties`
--

CREATE TABLE `experiential_course_grade_aftr_penalties` (
  `id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_course_grade_aftr_penalty_items`
--

CREATE TABLE `experiential_course_grade_aftr_penalty_items` (
  `items_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `academic_credits` int(11) NOT NULL,
  `grade_aftr_penalty` float NOT NULL,
  `grade_point_avg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_course_wise_grades`
--

CREATE TABLE `experiential_course_wise_grades` (
  `id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_course_wise_grade_items`
--

CREATE TABLE `experiential_course_wise_grade_items` (
  `items_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `academic_credits` text NOT NULL,
  `credit_value` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_course_wise_penalities_items`
--

CREATE TABLE `experiential_course_wise_penalities_items` (
  `items_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `courses_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `academic_credits` int(11) NOT NULL,
  `penalties` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_course_wise_penalties`
--

CREATE TABLE `experiential_course_wise_penalties` (
  `id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_evaluation_components_items`
--

CREATE TABLE `experiential_evaluation_components_items` (
  `id` int(11) NOT NULL,
  `ec_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `component_name` varchar(50) NOT NULL,
  `weightage` float NOT NULL,
  `remaining_weightage` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_grade_allocation_items`
--

CREATE TABLE `experiential_grade_allocation_items` (
  `grade_allocation_item_id` int(11) NOT NULL,
  `grade_allocation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_id` varchar(100) NOT NULL,
  `grade_value` varchar(30) NOT NULL,
  `component_weightages` varchar(200) DEFAULT NULL,
  `grade_point` decimal(10,2) DEFAULT NULL,
  `penalties` decimal(10,2) DEFAULT NULL,
  `final_grade_point` decimal(10,2) DEFAULT NULL,
  `cgpa` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_grade_allocation_master`
--

CREATE TABLE `experiential_grade_allocation_master` (
  `grade_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `course_id` int(11) NOT NULL,
  `credit` decimal(4,2) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `published_by_faculty` tinyint(1) NOT NULL DEFAULT 0,
  `published_by_faculty_date` datetime DEFAULT NULL,
  `final_publish` tinyint(1) NOT NULL DEFAULT 0,
  `final_publish_date` datetime DEFAULT NULL,
  `added_by` char(30) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `added_by_ip_address` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_learning_allotment_items`
--

CREATE TABLE `experiential_learning_allotment_items` (
  `allot_items_id` int(11) NOT NULL,
  `allotment_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_learning_allotment_master`
--

CREATE TABLE `experiential_learning_allotment_master` (
  `allotment_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_learning_components_master`
--

CREATE TABLE `experiential_learning_components_master` (
  `elc_id` int(11) NOT NULL,
  `elc_name` varchar(100) NOT NULL,
  `elc_desc` varchar(300) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_learning_master`
--

CREATE TABLE `experiential_learning_master` (
  `el_id` int(11) NOT NULL,
  `elc_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `terms_id` int(11) NOT NULL,
  `start_date` varchar(20) NOT NULL,
  `end_date` varchar(20) NOT NULL,
  `start_date_type` date DEFAULT NULL,
  `end_date_type` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `credit_name` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_learning_projects`
--

CREATE TABLE `experiential_learning_projects` (
  `el_project_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `el_component_id` int(11) NOT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `project_location` varchar(100) NOT NULL,
  `hosting_org` varchar(150) DEFAULT NULL,
  `project_name` varchar(300) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0,
  `added_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `experiential_learning_project_allocation`
--

CREATE TABLE `experiential_learning_project_allocation` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `student_ids` char(100) NOT NULL,
  `el_project_id` int(11) NOT NULL,
  `group_name` varchar(200) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `added_date` datetime NOT NULL,
  `updated_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_assignment`
--

CREATE TABLE `faculty_assignment` (
  `assignment_id` int(11) NOT NULL,
  `document_type` int(11) DEFAULT NULL,
  `document_title` varchar(100) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `updated_by` varchar(11) NOT NULL,
  `session` int(2) NOT NULL DEFAULT 0,
  `cmn_terms` varchar(5) NOT NULL,
  `section` int(4) DEFAULT 0,
  `cc_id` int(2) NOT NULL DEFAULT 0,
  `department` int(5) NOT NULL DEFAULT 0,
  `course_id` varchar(50) NOT NULL,
  `updated_date` varchar(100) NOT NULL,
  `due_date` datetime NOT NULL,
  `notification_status` tinyint(4) NOT NULL DEFAULT 0,
  `empl_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feed_master`
--

CREATE TABLE `feed_master` (
  `id` int(11) NOT NULL,
  `Auto_no` varchar(255) NOT NULL,
  `template_code` varchar(255) NOT NULL,
  `academic_year_id` varchar(255) NOT NULL,
  `term_id` varchar(255) NOT NULL,
  `question_type` tinyint(4) NOT NULL,
  `selected_question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fee_collector`
--

CREATE TABLE `fee_collector` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `head_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `paid_amount` float NOT NULL,
  `due_amount` float NOT NULL,
  `payment_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fee_waiver`
--

CREATE TABLE `fee_waiver` (
  `id` bigint(10) NOT NULL,
  `stu_id` varchar(20) NOT NULL,
  `type` int(2) NOT NULL,
  `cmn_terms` varchar(2) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `remarks` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `final_grade_no`
--

CREATE TABLE `final_grade_no` (
  `id` int(11) NOT NULL,
  `grade_no` int(10) NOT NULL,
  `academic` int(10) NOT NULL,
  `student` int(10) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `final_result`
--

CREATE TABLE `final_result` (
  `id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `stu_id` varchar(100) NOT NULL,
  `stu_name` varchar(250) NOT NULL,
  `added_year` varchar(10) NOT NULL,
  `added_month` varchar(20) NOT NULL,
  `total_sgpc` double DEFAULT NULL,
  `total_cgpa` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `formstudent`
--

CREATE TABLE `formstudent` (
  `id` bigint(20) NOT NULL,
  `stu_name` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `roll_number` varchar(255) NOT NULL,
  `Form_id` varchar(255) NOT NULL,
  `core_course1` varchar(255) NOT NULL,
  `ge1` varchar(255) NOT NULL,
  `core_course2` varchar(255) NOT NULL,
  `ge2` varchar(255) NOT NULL,
  `comp_evs` varchar(255) NOT NULL,
  `aecc1` varchar(255) NOT NULL,
  `aecc2` varchar(255) NOT NULL,
  `degree` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `ap_id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `form_fill_table`
--

CREATE TABLE `form_fill_table` (
  `id` int(10) NOT NULL,
  `stu_id` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE `global_settings` (
  `global_setting_id` int(11) NOT NULL,
  `gs_display_name` varchar(100) NOT NULL,
  `gs_system_name` varchar(100) NOT NULL,
  `gs_category` smallint(6) NOT NULL,
  `gs_content` text DEFAULT NULL,
  `gs_comments` text DEFAULT NULL,
  `gs_status` tinyint(4) NOT NULL DEFAULT 0,
  `gs_added_date` datetime DEFAULT NULL,
  `gs_updated_date` datetime DEFAULT NULL,
  `gs_added_by` int(11) DEFAULT NULL,
  `gs_updated_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grade_allocatione_new`
--

CREATE TABLE `grade_allocatione_new` (
  `log_id` bigint(20) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `grade_detail` longtext DEFAULT NULL,
  `grade_type` enum('EXP','CORE') DEFAULT NULL,
  `added_date` datetime NOT NULL,
  `added_by` char(30) DEFAULT NULL,
  `ip_address` varchar(30) NOT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `flag` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grade_allocation_items`
--

CREATE TABLE `grade_allocation_items` (
  `grade_allocation_item_id` bigint(20) NOT NULL,
  `grade_allocation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_id` varchar(100) NOT NULL,
  `grade_value` varchar(50) NOT NULL,
  `number_value` varchar(50) DEFAULT NULL,
  `reval_date` date NOT NULL,
  `publish_date` date NOT NULL,
  `flag` char(1) DEFAULT 'R',
  `obtained_marks` int(4) NOT NULL DEFAULT 0,
  `total_marks` int(4) NOT NULL DEFAULT 0,
  `percent` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade_allocation_items`
--

INSERT INTO `grade_allocation_items` (`grade_allocation_item_id`, `grade_allocation_id`, `student_id`, `component_id`, `grade_value`, `number_value`, `reval_date`, `publish_date`, `flag`, `obtained_marks`, `total_marks`, `percent`) VALUES
(3, 1, 1, '1', 'A', '20', '0000-00-00', '0000-00-00', 'R', 20, 40, 50);

-- --------------------------------------------------------

--
-- Table structure for table `grade_allocation_log`
--

CREATE TABLE `grade_allocation_log` (
  `log_id` bigint(20) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `grade_detail` longtext DEFAULT NULL,
  `grade_type` enum('EXP','CORE') DEFAULT NULL,
  `added_date` datetime NOT NULL,
  `added_by` char(30) DEFAULT NULL,
  `ip_address` varchar(30) NOT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `flag` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade_allocation_log`
--

INSERT INTO `grade_allocation_log` (`log_id`, `grade_id`, `grade_detail`, `grade_type`, `added_date`, `added_by`, `ip_address`, `updated_by`, `updated_date`, `flag`) VALUES
(1, 1, '{\"master\":{\"grade_id\":\"1\",\"academic_id\":\"1\",\"year\":\"0\",\"department_id\":\"1\",\"employee_id\":\"EMP-F-001\",\"term_id\":\"1\",\"course_id\":\"1\",\"component_id\":\"0\",\"status\":\"0\",\"published_by_faculty\":\"0\",\"published_by_faculty_date\":null,\"added_by\":\"2\",\"added_date\":\"2023-08-22 10:54:15\",\"added_by_ip_address\":\"::1\",\"cc_id\":\"1\",\"cmn_terms\":\"t1\",\"department\":\"1\",\"ge_id\":\"0\",\"session\":\"1\",\"degree_id\":\"1\",\"flag\":\"R\",\"updated_by\":null,\"updated_date\":\"2023-08-22 10:54:15\",\"csrftoken\":\"f2936bfcb2f6fa87d3916450b5ccc262a2e6feb6d431090d71913887e5eb3cf5\",\"exam_month\":null},\"items\":[]}', 'CORE', '2023-08-22 11:09:25', '2', '::1', '::1', '2023-08-22 11:09:25', 'R'),
(2, 1, '{\"master\":{\"grade_id\":\"1\",\"academic_id\":\"1\",\"year\":\"0\",\"department_id\":\"1\",\"employee_id\":\"EMP-F-001\",\"term_id\":\"1\",\"course_id\":\"1\",\"component_id\":\"0\",\"status\":\"0\",\"published_by_faculty\":\"0\",\"published_by_faculty_date\":null,\"added_by\":\"2\",\"added_date\":\"2023-08-22 10:54:15\",\"added_by_ip_address\":\"::1\",\"cc_id\":\"1\",\"cmn_terms\":\"t1\",\"department\":\"1\",\"ge_id\":\"0\",\"session\":\"1\",\"degree_id\":\"1\",\"flag\":\"R\",\"updated_by\":null,\"updated_date\":\"2023-08-22 10:54:15\",\"csrftoken\":\"f2936bfcb2f6fa87d3916450b5ccc262a2e6feb6d431090d71913887e5eb3cf5\",\"exam_month\":null},\"updated_by\":\"::1\",\"updated_date\":\"2023-08-22 11:09:25\",\"items\":[]}', 'CORE', '2023-08-22 11:09:25', '2', '::1', NULL, '2023-08-22 11:09:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grade_allocation_master`
--

CREATE TABLE `grade_allocation_master` (
  `grade_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(30) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `published_by_faculty` tinyint(1) NOT NULL DEFAULT 0,
  `published_by_faculty_date` datetime DEFAULT NULL,
  `added_by` char(30) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `added_by_ip_address` varchar(30) DEFAULT NULL,
  `cc_id` int(10) NOT NULL DEFAULT 0,
  `cmn_terms` varchar(10) NOT NULL,
  `department` varchar(10) DEFAULT NULL,
  `ge_id` int(10) NOT NULL DEFAULT 0,
  `session` int(5) NOT NULL DEFAULT 0,
  `degree_id` int(5) NOT NULL,
  `flag` varchar(10) NOT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `csrftoken` text NOT NULL,
  `exam_month` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade_allocation_master`
--

INSERT INTO `grade_allocation_master` (`grade_id`, `academic_id`, `year`, `department_id`, `employee_id`, `term_id`, `course_id`, `component_id`, `status`, `published_by_faculty`, `published_by_faculty_date`, `added_by`, `added_date`, `added_by_ip_address`, `cc_id`, `cmn_terms`, `department`, `ge_id`, `session`, `degree_id`, `flag`, `updated_by`, `updated_date`, `csrftoken`, `exam_month`) VALUES
(1, 1, 0, 1, 'EMP-F-001', 1, 1, 0, 0, 0, NULL, '2', '2023-08-22 10:54:15', '::1', 1, 't1', '1', 0, 1, 1, 'R', NULL, '2023-08-22 10:54:15', '872696d5ef12b0f0a88e86e29a72f9308dc4123de3649b8ef117383a51e124a9', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grade_allocation_report`
--

CREATE TABLE `grade_allocation_report` (
  `grade_report_id` int(11) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `employee_id` varchar(30) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `added_by` char(30) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `added_by_ip_address` varchar(30) DEFAULT NULL,
  `course_id` varchar(50) DEFAULT NULL,
  `cc_id` int(10) DEFAULT 0,
  `ge_id` int(10) NOT NULL DEFAULT 0,
  `session` int(10) DEFAULT NULL,
  `cmn_terms` varchar(10) DEFAULT NULL,
  `tabl_id` bigint(20) NOT NULL,
  `flag` varchar(10) NOT NULL DEFAULT 'R'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grade_allocation_report_items`
--

CREATE TABLE `grade_allocation_report_items` (
  `grade_allocation_report_item_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `component_grades` text DEFAULT NULL,
  `component_weightages` text DEFAULT NULL,
  `grade_point` float DEFAULT NULL,
  `ge_id` int(5) NOT NULL DEFAULT 0,
  `tabl_id` int(20) NOT NULL DEFAULT 0,
  `sort` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grade_sheet`
--

CREATE TABLE `grade_sheet` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `year_id` tinyint(1) NOT NULL,
  `sr_no` int(11) NOT NULL,
  `student_id` char(30) NOT NULL,
  `deleted` tinyint(1) DEFAULT 0,
  `added_date` datetime NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ic_category`
--

CREATE TABLE `ic_category` (
  `category_id` int(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_desc` text NOT NULL,
  `backgroundColor` varchar(11) NOT NULL,
  `borderColor` varchar(11) NOT NULL,
  `textColor` varchar(11) NOT NULL,
  `deleted` int(9) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ic_events`
--

CREATE TABLE `ic_events` (
  `eid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `username` varchar(12) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `backgroundColor` varchar(11) NOT NULL,
  `borderColor` varchar(11) NOT NULL,
  `textColor` varchar(11) NOT NULL,
  `description` text DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `url` varchar(255) NOT NULL,
  `allDay` enum('true','false') NOT NULL DEFAULT 'true',
  `rendering` varchar(10) NOT NULL,
  `overlap` enum('true','false') NOT NULL DEFAULT 'true',
  `recurdays` int(4) NOT NULL,
  `recurend` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `filename` varchar(250) NOT NULL,
  `pubDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` int(9) NOT NULL DEFAULT 0,
  `only_faculty` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `insertgehelpertable`
--

CREATE TABLE `insertgehelpertable` (
  `id` bigint(20) NOT NULL,
  `stu_id` varchar(50) NOT NULL,
  `ge_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instalment`
--

CREATE TABLE `instalment` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL,
  `endDate` varchar(255) NOT NULL,
  `academic_year_id` int(10) NOT NULL,
  `term_id` varchar(2) NOT NULL,
  `fees` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instructor_feed`
--

CREATE TABLE `instructor_feed` (
  `id` int(11) NOT NULL,
  `course` varchar(50) NOT NULL,
  `feed` varchar(50) DEFAULT NULL,
  `instructor` varchar(50) NOT NULL,
  `batch` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `question_no_c` varchar(255) DEFAULT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `job_announcement`
--

CREATE TABLE `job_announcement` (
  `id` int(100) NOT NULL,
  `job_announcement_id` varchar(100) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `no_of_position_offered` varchar(100) NOT NULL,
  `functional_area` varchar(100) NOT NULL,
  `required_skill_set` varchar(100) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `looking_to_hire_for` varchar(100) NOT NULL,
  `initial_place_of_position` varchar(100) NOT NULL,
  `published_date` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `late_fine`
--

CREATE TABLE `late_fine` (
  `id` int(10) NOT NULL,
  `batch` varchar(200) NOT NULL,
  `term` varchar(50) NOT NULL,
  `stu_id` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `submit_date` date NOT NULL,
  `mmp_txn` varchar(255) NOT NULL,
  `mer_txn` varchar(255) NOT NULL,
  `bank_txn` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `prod` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `f_code` varchar(255) NOT NULL,
  `clientcode` varchar(255) NOT NULL,
  `merchant_id` varchar(255) NOT NULL,
  `academic_id` int(10) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_aecc`
--

CREATE TABLE `master_aecc` (
  `aecc_id` int(10) NOT NULL,
  `aecc_name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_aeccge`
--

CREATE TABLE `master_aeccge` (
  `aeccge_id` int(10) NOT NULL,
  `department` int(10) NOT NULL,
  `ge_id` int(10) NOT NULL,
  `aecc_id` int(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `degree_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_ge`
--

CREATE TABLE `master_ge` (
  `ge_id` int(10) NOT NULL,
  `general_elective_name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `degree_id` int(10) NOT NULL,
  `department` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `non_academic_course`
--

CREATE TABLE `non_academic_course` (
  `id` int(1) NOT NULL,
  `academic_year` tinyint(2) NOT NULL,
  `session` tinyint(2) NOT NULL,
  `credit_course` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `non_collegiate_data`
--

CREATE TABLE `non_collegiate_data` (
  `id` int(4) NOT NULL,
  `stu_id` varchar(20) DEFAULT NULL,
  `stu_name` varchar(250) DEFAULT NULL,
  `term_id` varchar(7) DEFAULT NULL,
  `academic_id` varchar(11) DEFAULT NULL,
  `session_id` varchar(10) DEFAULT NULL,
  `course_id` varchar(9) DEFAULT NULL,
  `cc_id` varchar(11) DEFAULT NULL,
  `exam_roll` varchar(12) DEFAULT NULL,
  `reg_no` varchar(12) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `cc_1` varchar(4) DEFAULT NULL,
  `cc_2` varchar(4) DEFAULT NULL,
  `ge` varchar(3) DEFAULT NULL,
  `aecc` varchar(4) DEFAULT NULL,
  `class_roll` varchar(10) DEFAULT NULL,
  `father_name` varchar(31) DEFAULT NULL,
  `new_col` varchar(11) DEFAULT NULL,
  `cc_3` varchar(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `non_collegiate_stu_data`
--

CREATE TABLE `non_collegiate_stu_data` (
  `id` int(11) NOT NULL,
  `exam_roll` varchar(50) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `academic_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` varchar(20) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `class_roll` varchar(15) NOT NULL,
  `stu_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `non_credit_course_allotment`
--

CREATE TABLE `non_credit_course_allotment` (
  `id` int(2) NOT NULL,
  `stu_id` varchar(100) NOT NULL,
  `credit_course_id` int(2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `otp_manage`
--

CREATE TABLE `otp_manage` (
  `id` int(11) NOT NULL,
  `u_id` varchar(50) NOT NULL,
  `otp` varchar(50) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `participants_login`
--

CREATE TABLE `participants_login` (
  `user_id` int(11) NOT NULL,
  `participant_fname` varchar(255) DEFAULT NULL,
  `participant_lname` varchar(255) DEFAULT NULL,
  `participant_email` varchar(255) DEFAULT NULL,
  `participant_username` varchar(255) DEFAULT NULL,
  `participant_pword` varchar(255) DEFAULT NULL,
  `participant_continue` tinyint(4) DEFAULT 0,
  `participant_Alumni` tinyint(4) DEFAULT 0,
  `participant_Active` tinyint(4) DEFAULT 0,
  `participant_yop` varchar(255) DEFAULT 'null',
  `participants_file` varchar(255) DEFAULT 'null',
  `participant_academic` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `role_id` int(10) DEFAULT 0,
  `empl_id` varchar(50) DEFAULT NULL,
  `fa_salutation` varchar(255) DEFAULT '1',
  `alumni_url` varchar(255) DEFAULT NULL,
  `linked_in` varchar(300) DEFAULT NULL,
  `roll_no` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `participants_login`
--

INSERT INTO `participants_login` (`user_id`, `participant_fname`, `participant_lname`, `participant_email`, `participant_username`, `participant_pword`, `participant_continue`, `participant_Alumni`, `participant_Active`, `participant_yop`, `participants_file`, `participant_academic`, `student_id`, `role_id`, `empl_id`, `fa_salutation`, `alumni_url`, `linked_in`, `roll_no`) VALUES
(1, 'raushan', NULL, NULL, '', NULL, 1, 0, 0, '', NULL, 1, 3, 0, NULL, '1', 'raushanF-2023-1', NULL, 'F-2023-1');

-- --------------------------------------------------------

--
-- Table structure for table `pass_out_students`
--

CREATE TABLE `pass_out_students` (
  `id` int(5) NOT NULL,
  `stu_id` varchar(15) NOT NULL,
  `academic_id` int(2) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `stream` int(2) NOT NULL,
  `session` int(2) NOT NULL,
  `pass_out_no` int(5) NOT NULL DEFAULT 0,
  `publish_date` varchar(25) NOT NULL,
  `submit_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pass_update`
--

CREATE TABLE `pass_update` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `flag` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment_detail`
--

CREATE TABLE `payment_detail` (
  `id` int(11) NOT NULL,
  `u_id` varchar(50) NOT NULL,
  `exam_id` varchar(50) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `total_fee` varchar(50) NOT NULL,
  `exam_fee` varchar(50) NOT NULL,
  `late_fine` varchar(50) NOT NULL,
  `submit_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `mmp_txn` varchar(50) NOT NULL,
  `mer_txn` varchar(50) NOT NULL,
  `bank_txn` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `prod` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `f_code` varchar(50) NOT NULL,
  `clientcode` varchar(50) NOT NULL,
  `merchant_id` varchar(50) NOT NULL,
  `term_id` varchar(50) DEFAULT NULL,
  `acad_id` int(11) DEFAULT NULL,
  `non_collegiate_status` int(11) NOT NULL,
  `payment_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgnon_payment_detail`
--

CREATE TABLE `pgnon_payment_detail` (
  `id` int(11) NOT NULL,
  `u_id` varchar(50) NOT NULL,
  `exam_id` varchar(50) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `total_fee` varchar(50) NOT NULL,
  `exam_fee` varchar(50) NOT NULL,
  `late_fine` varchar(50) NOT NULL,
  `submit_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `mmp_txn` varchar(50) NOT NULL,
  `mer_txn` varchar(50) NOT NULL,
  `bank_txn` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `prod` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `f_code` varchar(50) NOT NULL,
  `clientcode` varchar(50) NOT NULL,
  `merchant_id` varchar(50) NOT NULL,
  `term_id` varchar(50) DEFAULT NULL,
  `acad_id` int(11) DEFAULT NULL,
  `non_collegiate_status` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pg_non_form_data`
--

CREATE TABLE `pg_non_form_data` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `year_exam` varchar(50) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `term_id` varchar(50) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `date_of_birth` varchar(50) NOT NULL,
  `examination_id` varchar(50) NOT NULL,
  `examination_name` varchar(50) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `college_name` varchar(50) NOT NULL,
  `cc_1` varchar(50) DEFAULT NULL,
  `cc_2` varchar(50) DEFAULT NULL,
  `cc_3` varchar(50) DEFAULT NULL,
  `cc_paper_name` varchar(50) DEFAULT NULL,
  `ge_paper_name` varchar(50) DEFAULT NULL,
  `aecc_paper_name` varchar(50) DEFAULT NULL,
  `created_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `payment_status` int(11) NOT NULL DEFAULT 0,
  `u_id` varchar(50) NOT NULL,
  `payment_activation` int(11) NOT NULL,
  `non_collegiate_status` int(11) NOT NULL DEFAULT 0,
  `email` varchar(50) NOT NULL,
  `default_d_time` datetime NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) NOT NULL,
  `exam_month_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `placement_master`
--

CREATE TABLE `placement_master` (
  `id` int(10) NOT NULL,
  `registration_id` varchar(100) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirm_password` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `placement_selection_process`
--

CREATE TABLE `placement_selection_process` (
  `id` int(10) NOT NULL,
  `selection_id` varchar(100) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `selection_process` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `program_design_master`
--

CREATE TABLE `program_design_master` (
  `pd_id` int(11) NOT NULL,
  `short_code` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `pd_name` int(11) NOT NULL,
  `se_name` varchar(200) NOT NULL,
  `pd_desc` varchar(200) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `no_days` int(11) NOT NULL,
  `no_weeks` float NOT NULL,
  `sort_no` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `program_master`
--

CREATE TABLE `program_master` (
  `pm_id` int(11) NOT NULL,
  `short_id` varchar(20) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `pm_name` varchar(100) NOT NULL,
  `pm_desc` varchar(100) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_documents_followup`
--

CREATE TABLE `promotion_documents_followup` (
  `id` int(2) NOT NULL,
  `form_id` varchar(20) NOT NULL,
  `date` varchar(25) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_master`
--

CREATE TABLE `promotion_master` (
  `id` int(5) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `nextSem` varchar(10) NOT NULL DEFAULT '0',
  `attendance` varchar(10) NOT NULL,
  `cmn_terms` varchar(30) DEFAULT '0',
  `semester_paper_count` int(5) NOT NULL,
  `appeared_paper` varchar(1) DEFAULT NULL,
  `component_paper` varchar(100) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0,
  `degree_id` int(10) NOT NULL DEFAULT 0,
  `session` int(11) NOT NULL,
  `academic_year_list` int(11) NOT NULL,
  `seperate_status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1 means not separate and 0 means separate'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promotion_seperate_items`
--

CREATE TABLE `promotion_seperate_items` (
  `id` int(11) NOT NULL,
  `cmn_terms` varchar(2) NOT NULL,
  `semester_paper_count` int(10) NOT NULL,
  `master_id` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_master`
--

CREATE TABLE `question_master` (
  `id` int(11) NOT NULL,
  `Auto_no` varchar(255) NOT NULL,
  `text_filed` varchar(255) NOT NULL,
  `rating_required` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `question_type` int(11) NOT NULL,
  `rating_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating_master`
--

CREATE TABLE `rating_master` (
  `id` int(11) NOT NULL,
  `Auto_no` varchar(255) NOT NULL,
  `text_filed` varchar(255) NOT NULL,
  `rating_value` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `razrcard`
--

CREATE TABLE `razrcard` (
  `card_id` bigint(20) NOT NULL,
  `id` varchar(100) DEFAULT NULL,
  `entity` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `last4` varchar(16) DEFAULT NULL,
  `network` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `issuer` varchar(255) DEFAULT NULL,
  `international` varchar(255) DEFAULT NULL,
  `emi` varchar(255) DEFAULT NULL,
  `razr_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `razr_records`
--

CREATE TABLE `razr_records` (
  `rzr_id` bigint(20) NOT NULL,
  `id` varchar(255) DEFAULT NULL,
  `entity` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `international` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `amount_refunded` varchar(255) DEFAULT NULL,
  `refund_status` varchar(255) DEFAULT NULL,
  `captured` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `card_id` varchar(255) DEFAULT NULL,
  `card_details` text NOT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `wallet` varchar(255) DEFAULT NULL,
  `vpa` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `fee` varchar(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `error_code` varchar(255) DEFAULT NULL,
  `error_description` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `applicant_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reference_grade_master`
--

CREATE TABLE `reference_grade_master` (
  `reference_id` int(11) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `degree_id` int(5) NOT NULL,
  `session` int(10) NOT NULL DEFAULT 0,
  `cc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reference_grade_master`
--

INSERT INTO `reference_grade_master` (`reference_id`, `academic_year_id`, `status`, `degree_id`, `session`, `cc_id`) VALUES
(1, 0, 0, 1, 1, 1),
(3, 0, 0, 1, 1, 1),
(4, 0, 0, 1, 1, 1),
(5, 0, 0, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `reference_grade_master_items`
--

CREATE TABLE `reference_grade_master_items` (
  `reference_item_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `letter_grade` varchar(15) NOT NULL,
  `number_grade` float NOT NULL,
  `marks_from` int(5) NOT NULL,
  `marks_to` int(5) NOT NULL,
  `des` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reference_grade_master_items`
--

INSERT INTO `reference_grade_master_items` (`reference_item_id`, `reference_id`, `letter_grade`, `number_grade`, `marks_from`, `marks_to`, `des`) VALUES
(1, 1, 'A', 8, 80, 89, ''),
(3, 2, 'A', 8, 80, 90, ''),
(4, 3, 'A', 8, 80, 90, ''),
(5, 4, 'B', 8, 70, 80, ''),
(6, 5, 'C', 5, 60, 70, '');

-- --------------------------------------------------------

--
-- Table structure for table `registration_payment`
--

CREATE TABLE `registration_payment` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `year_exam` varchar(50) DEFAULT NULL,
  `academic_year_id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `term_id` varchar(50) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `date_of_birth` varchar(50) NOT NULL,
  `examination_id` varchar(50) NOT NULL,
  `examination_name` varchar(50) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `college_name` varchar(50) NOT NULL,
  `cc_paper_name` varchar(50) DEFAULT NULL,
  `ge_paper_name` varchar(50) DEFAULT NULL,
  `aecc_paper_name` varchar(50) DEFAULT NULL,
  `created_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `payment_status` int(11) NOT NULL DEFAULT 0,
  `u_id` varchar(50) NOT NULL,
  `payment_activation` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `default_d_time` datetime NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(11) NOT NULL,
  `pay_mode` varchar(20) DEFAULT NULL,
  `roll_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report_card_student`
--

CREATE TABLE `report_card_student` (
  `id` int(11) NOT NULL,
  `stu_id` varchar(100) NOT NULL,
  `stu_name` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `otp` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `result_management`
--

CREATE TABLE `result_management` (
  `id` int(11) NOT NULL,
  `gpa_from` float(4,2) NOT NULL,
  `gpa_to` float(4,2) NOT NULL,
  `result` varchar(80) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reval_status`
--

CREATE TABLE `reval_status` (
  `id` bigint(20) NOT NULL,
  `tabl_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `updated_date` datetime NOT NULL DEFAULT current_timestamp(),
  `changed_text` text NOT NULL,
  `flag` char(1) NOT NULL DEFAULT 'R'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `room_no` varchar(50) NOT NULL,
  `seating_capacity` varchar(50) NOT NULL,
  `last_modified_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` date NOT NULL,
  `department` int(6) NOT NULL,
  `seating_capacity_exam` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room_mapping`
--

CREATE TABLE `room_mapping` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `last_modified_date` date NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sanctioned_seat`
--

CREATE TABLE `sanctioned_seat` (
  `id` int(10) NOT NULL,
  `degree_id` int(5) NOT NULL,
  `course` int(10) NOT NULL,
  `session` int(10) NOT NULL,
  `core_course` int(10) NOT NULL,
  `generic_elective` int(10) NOT NULL,
  `max_seat` int(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_management`
--

CREATE TABLE `scholarship_management` (
  `id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `gpa_from` float(4,2) NOT NULL,
  `gpa_to` float(4,2) NOT NULL,
  `scholarship_fee_wavier` float NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `seating_operation`
--

CREATE TABLE `seating_operation` (
  `id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `department` varchar(40) DEFAULT NULL,
  `batch` varchar(40) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` date NOT NULL,
  `last_modified_date` date NOT NULL,
  `roll_start` varchar(100) NOT NULL,
  `room_no` varchar(100) NOT NULL,
  `roll_end` varchar(100) NOT NULL,
  `academic_year_id` int(11) DEFAULT NULL,
  `term_id` varchar(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `selected_roll` text NOT NULL,
  `allocated_seat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `section_allotment`
--

CREATE TABLE `section_allotment` (
  `id` int(5) NOT NULL,
  `academic_year_list` int(1) NOT NULL,
  `session` int(5) NOT NULL,
  `academic_id` int(5) NOT NULL,
  `term_id` int(5) NOT NULL,
  `stu_id` int(5) NOT NULL,
  `section` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `section_master`
--

CREATE TABLE `section_master` (
  `id` int(10) NOT NULL,
  `term_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `academic_year_id` int(5) NOT NULL,
  `year_id` int(11) NOT NULL,
  `session` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section_master`
--

INSERT INTO `section_master` (`id`, `term_id`, `name`, `description`, `status`, `academic_year_id`, `year_id`, `session`) VALUES
(1, 1, 'A', '', 0, 1, 1, 1),
(2, 1, 'A', '', 0, 1, 1, 1),
(3, 1, 'A', '', 0, 1, 1, 1),
(4, 1, 'A', '', 0, 1, 1, 1),
(5, 1, 'A', '', 0, 1, 1, 1),
(6, 1, 'A', '', 0, 1, 1, 1),
(7, 1, 'A', '', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `semester_fee_collection`
--

CREATE TABLE `semester_fee_collection` (
  `id` int(11) NOT NULL,
  `batch` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `class_roll` int(11) NOT NULL,
  `exam_id` varchar(50) NOT NULL,
  `department` varchar(25) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(75) NOT NULL,
  `semester` varchar(11) NOT NULL,
  `fee` varchar(50) NOT NULL,
  `due_amount` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `submit_date` date NOT NULL,
  `mmp_txn` varchar(50) NOT NULL,
  `mer_txn` varchar(50) NOT NULL,
  `bank_txn` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `prod` varchar(50) NOT NULL,
  `f_code` varchar(50) NOT NULL,
  `clientcode` varchar(50) NOT NULL,
  `merchant_id` varchar(50) NOT NULL,
  `stu_id` varchar(50) NOT NULL,
  `date` varchar(100) NOT NULL,
  `type` char(1) NOT NULL DEFAULT 'R',
  `description` varchar(255) DEFAULT NULL,
  `live_status` varchar(20) DEFAULT NULL,
  `pay_mode` varchar(100) DEFAULT NULL,
  `pf` float DEFAULT NULL,
  `stx` float DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `addon_fee` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `semester_wise_attendance_report`
--

CREATE TABLE `semester_wise_attendance_report` (
  `id` int(5) NOT NULL,
  `session` int(5) NOT NULL DEFAULT 0,
  `cmn_terms` varchar(10) NOT NULL DEFAULT '0',
  `cc_id` int(5) NOT NULL DEFAULT 0,
  `ge_id` int(5) DEFAULT 0,
  `department_id` int(5) DEFAULT 0,
  `department` int(5) DEFAULT 0,
  `employee_id` varchar(15) DEFAULT '0',
  `course_id` int(5) NOT NULL DEFAULT 0,
  `component_paper` varchar(100) DEFAULT '0',
  `u_id` varchar(15) NOT NULL DEFAULT '0',
  `roll_no` int(5) DEFAULT 0,
  `conducted_class` int(5) DEFAULT 0,
  `attended_class` int(10) DEFAULT 0,
  `required_percentage` int(5) DEFAULT 0,
  `attend_status` varchar(10) NOT NULL DEFAULT '0',
  `attend_remarks` varchar(25) NOT NULL DEFAULT '0',
  `effective_date` date DEFAULT NULL,
  `status` int(5) DEFAULT 0,
  `degree_id` int(5) DEFAULT NULL,
  `payment_status` int(4) DEFAULT NULL,
  `overall_percent` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester_wise_attendance_report`
--

INSERT INTO `semester_wise_attendance_report` (`id`, `session`, `cmn_terms`, `cc_id`, `ge_id`, `department_id`, `department`, `employee_id`, `course_id`, `component_paper`, `u_id`, `roll_no`, `conducted_class`, `attended_class`, `required_percentage`, `attend_status`, `attend_remarks`, `effective_date`, `status`, `degree_id`, `payment_status`, `overall_percent`) VALUES
(1, 1, 't1', 1, 0, 0, 1, '0', 0, 'ESE(T),ESE(P),CIA', 'F-2023-1', 0, 3, 0, 2, '0', '0', NULL, 0, 1, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `seminar_association`
--

CREATE TABLE `seminar_association` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `time` varchar(100) NOT NULL,
  `reg_amt` varchar(100) NOT NULL,
  `mmp_txn` varchar(100) NOT NULL,
  `mer_txn` varchar(100) NOT NULL,
  `bank_txn` varchar(100) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `prod` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `f_code` varchar(10) NOT NULL,
  `clientcode` varchar(20) NOT NULL,
  `merchant_id` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `pay_mode` varchar(20) NOT NULL,
  `create_date` date NOT NULL,
  `title` varchar(255) NOT NULL,
  `theme` varchar(255) NOT NULL,
  `instituition` varchar(255) NOT NULL,
  `nationality` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `session_info`
--

CREATE TABLE `session_info` (
  `id` int(10) NOT NULL,
  `session` varchar(20) NOT NULL,
  `created_date` date NOT NULL DEFAULT '0000-00-00',
  `last_modified_date` date NOT NULL DEFAULT '0000-00-00',
  `status` int(2) NOT NULL DEFAULT 0,
  `acad_year_id` int(2) DEFAULT 0,
  `inactive_status` tinyint(4) NOT NULL DEFAULT 0,
  `tc_status` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session_info`
--

INSERT INTO `session_info` (`id`, `session`, `created_date`, `last_modified_date`, `status`, `acad_year_id`, `inactive_status`, `tc_status`) VALUES
(1, '2023-2027', '2023-05-17', '2023-05-17', 0, 1, 0, 'yes'),
(2, '2024-2028', '2024-05-17', '2028-05-17', 0, 2, 0, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `settlement_report`
--

CREATE TABLE `settlement_report` (
  `id` int(4) NOT NULL,
  `Atom Txn ID` bigint(12) DEFAULT NULL,
  `Txn Date` varchar(16) DEFAULT NULL,
  `Client Code` int(5) DEFAULT NULL,
  `Merchant Txn ID` int(6) DEFAULT NULL,
  `Product` varchar(13) DEFAULT NULL,
  `Discriminator` varchar(2) DEFAULT NULL,
  `Bank Ref No` varchar(18) DEFAULT NULL,
  `Gross Txn Amount` decimal(6,2) DEFAULT NULL,
  `Txn Charges` decimal(3,1) DEFAULT NULL,
  `Service Tax` decimal(3,2) DEFAULT NULL,
  `Total Chargeable` decimal(4,2) DEFAULT NULL,
  `Net Amount to be Paid` decimal(6,2) DEFAULT NULL,
  `Payment Status` varchar(13) DEFAULT NULL,
  `Settlement Date` varchar(16) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `email` varchar(36) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `form_id` varchar(11) DEFAULT NULL,
  `application_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `values` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `values`, `name`) VALUES
(1, 0, 'Active'),
(2, 1, 'Deactive');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `department` varchar(40) DEFAULT NULL,
  `batch` varchar(40) DEFAULT NULL,
  `registration_no` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` date NOT NULL,
  `last_modified_date` date NOT NULL,
  `alocated` int(11) NOT NULL,
  `date` date NOT NULL,
  `duration` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `batch_id` int(255) NOT NULL,
  `term_id` int(255) NOT NULL,
  `class_1` varchar(255) NOT NULL,
  `class_2` varchar(255) NOT NULL,
  `class_3` varchar(255) NOT NULL,
  `class_4` varchar(255) NOT NULL,
  `class_5` varchar(255) NOT NULL,
  `faculty_1` varchar(255) NOT NULL DEFAULT '0',
  `faculty_2` varchar(255) NOT NULL DEFAULT '0',
  `faculty_3` varchar(255) NOT NULL DEFAULT '0',
  `faculty_4` varchar(255) NOT NULL DEFAULT '0',
  `faculty_5` varchar(255) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `student_id` int(11) DEFAULT NULL,
  `updated_date` date NOT NULL,
  `section` int(6) NOT NULL,
  `class_6` varchar(50) DEFAULT NULL,
  `faculty_6` varchar(50) DEFAULT NULL,
  `class_7` varchar(50) DEFAULT NULL,
  `class_8` varchar(50) DEFAULT NULL,
  `faculty_7` varchar(50) DEFAULT NULL,
  `faculty_8` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_fee_details`
--

CREATE TABLE `student_fee_details` (
  `fee_details_id` int(11) NOT NULL,
  `participants_name` varchar(80) NOT NULL,
  `participants_id` varchar(80) NOT NULL,
  `gpa` float NOT NULL,
  `fee` double NOT NULL,
  `fee_discount` double NOT NULL,
  `total_fee` double NOT NULL,
  `student_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `tuition_fee` varchar(255) NOT NULL,
  `service_fee` varchar(255) DEFAULT NULL,
  `other_annual_charges` varchar(255) DEFAULT NULL,
  `Remarks` text NOT NULL,
  `t1_date` date NOT NULL DEFAULT '0000-00-00',
  `t2_date` date NOT NULL DEFAULT '0000-00-00',
  `t3_date` date NOT NULL DEFAULT '0000-00-00',
  `t4_date` date NOT NULL DEFAULT '0000-00-00',
  `t5_date` date NOT NULL DEFAULT '0000-00-00',
  `promoted` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_fee_details_log`
--

CREATE TABLE `student_fee_details_log` (
  `id` int(11) NOT NULL,
  `participants_id` varchar(255) NOT NULL,
  `fee_discount` varchar(255) NOT NULL,
  `total_fee` varchar(255) NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabulation_report`
--

CREATE TABLE `tabulation_report` (
  `tabl_id` int(10) NOT NULL,
  `academic_id` int(10) NOT NULL,
  `term_id` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` varchar(255) NOT NULL,
  `added_date` date NOT NULL DEFAULT '0000-00-00',
  `added_by_ip_address` varchar(255) DEFAULT NULL,
  `flag` varchar(10) NOT NULL DEFAULT 'R',
  `fail` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'if fail student added then 0 else 1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tabulation_report_items`
--

CREATE TABLE `tabulation_report_items` (
  `id` int(10) NOT NULL,
  `tabl_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `sgpa` float(4,2) DEFAULT NULL,
  `fail_in_ct_ids` varchar(255) DEFAULT NULL,
  `total_credit_point` float DEFAULT NULL,
  `total_grade_point` float DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `promotion_text` text NOT NULL,
  `final_remarks` varchar(2) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `grade_point` varchar(255) NOT NULL,
  `non_col_date` date NOT NULL DEFAULT '0000-00-00',
  `remarks` text NOT NULL COMMENT 'change final remarks according to pwc permission'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tc_fee_collection`
--

CREATE TABLE `tc_fee_collection` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `stu_id` varchar(55) NOT NULL,
  `acad_id` int(10) NOT NULL,
  `email_id` varchar(55) NOT NULL,
  `tc_number` int(5) NOT NULL,
  `mig_no` int(5) DEFAULT 0,
  `fee_type` varchar(15) DEFAULT NULL,
  `mmp_txn` varchar(50) NOT NULL,
  `mer_txn` varchar(50) NOT NULL,
  `bank_txn` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `prod` varchar(25) NOT NULL,
  `date` varchar(100) NOT NULL,
  `amount` int(10) NOT NULL,
  `f_code` varchar(10) NOT NULL,
  `clientcode` varchar(50) NOT NULL,
  `merchant_id` varchar(50) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `term_master`
--

CREATE TABLE `term_master` (
  `term_id` int(11) NOT NULL,
  `academic_year` int(1) NOT NULL DEFAULT 0,
  `academic_year_id` int(11) NOT NULL,
  `session` int(1) NOT NULL DEFAULT 0,
  `term_name` varchar(200) NOT NULL,
  `term_description` varchar(200) NOT NULL,
  `year_id` int(11) NOT NULL,
  `start_date` varchar(20) NOT NULL,
  `end_date` varchar(20) NOT NULL,
  `start_date_type` date DEFAULT NULL,
  `end_date_type` date DEFAULT NULL,
  `tot_no_of_credits` decimal(3,1) NOT NULL,
  `electives_credits` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `cmn_terms` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `term_master`
--

INSERT INTO `term_master` (`term_id`, `academic_year`, `academic_year_id`, `session`, `term_name`, `term_description`, `year_id`, `start_date`, `end_date`, `start_date_type`, `end_date_type`, `tot_no_of_credits`, `electives_credits`, `status`, `cmn_terms`) VALUES
(1, 1, 1, 1, 'First', 'Semester 1', 1, '01/07/2023', '31/12/2023', '2023-07-01', '2023-12-31', '20.0', 0, 0, 't1'),
(2, 1, 1, 1, 'Sem 2', 'Desc', 1, '22/12/2023', '21/06/2024', '2023-12-22', '2024-06-21', '60.0', 0, 0, 't2');

-- --------------------------------------------------------

--
-- Table structure for table `term_master_pwc`
--

CREATE TABLE `term_master_pwc` (
  `academic_year_id` int(11) NOT NULL,
  `term_name` varchar(200) NOT NULL,
  `term_description` varchar(200) NOT NULL,
  `year_id` int(11) NOT NULL,
  `start_date` varchar(20) NOT NULL,
  `end_date` varchar(20) NOT NULL,
  `start_date_type` date DEFAULT NULL,
  `end_date_type` date DEFAULT NULL,
  `tot_no_of_credits` decimal(3,1) NOT NULL,
  `electives_credits` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `cmn_terms` varchar(50) DEFAULT NULL,
  `ge_id` int(10) NOT NULL DEFAULT 0,
  `term_id` int(10) NOT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `todo_list`
--

CREATE TABLE `todo_list` (
  `toDo_id` int(11) NOT NULL,
  `toDo_category` tinyint(4) NOT NULL,
  `toDo_activity_date` datetime NOT NULL,
  `toDo_task_description` text NOT NULL,
  `toDo_assigned_to_id` varchar(10) DEFAULT NULL,
  `toDo_assigned_by` varchar(10) NOT NULL,
  `toDo_due_date` datetime NOT NULL,
  `toDo_priority` tinyint(4) NOT NULL,
  `toDo_status` tinyint(4) NOT NULL,
  `toDo_files` varchar(255) NOT NULL,
  `toDo_assigned_to` varchar(5) NOT NULL,
  `toDo_assigned_by_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trn`
--

CREATE TABLE `trn` (
  `id` bigint(20) NOT NULL,
  `Atom_Txn_ID` text NOT NULL,
  `Merchant_Txn_ID` text NOT NULL,
  `Product` text NOT NULL,
  `Bank_Name` text NOT NULL,
  `Txn_Status` text NOT NULL,
  `Bank_Ref_No` text NOT NULL,
  `Udf2` text NOT NULL,
  `Udf4` text NOT NULL,
  `Card_Number` text NOT NULL,
  `Description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tuition_fees`
--

CREATE TABLE `tuition_fees` (
  `id` int(10) NOT NULL,
  `session_id` int(5) NOT NULL DEFAULT 0,
  `cmn_terms` varchar(10) NOT NULL DEFAULT '0',
  `degree_id` int(5) NOT NULL DEFAULT 0,
  `department` int(5) NOT NULL DEFAULT 0,
  `feeForm_start_date` date NOT NULL,
  `feeForm_end_date` date NOT NULL,
  `status` int(5) NOT NULL DEFAULT 0,
  `feeForm_extended_date` date NOT NULL,
  `fineFee` float NOT NULL DEFAULT 0,
  `perday_number` int(11) NOT NULL DEFAULT 1,
  `product_id` varchar(255) NOT NULL,
  `account_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `txn_details`
--

CREATE TABLE `txn_details` (
  `id` int(11) NOT NULL,
  `atom_txn` varchar(100) NOT NULL,
  `merch` varchar(124) NOT NULL,
  `amount` varchar(123) NOT NULL,
  `application_no` varchar(124) NOT NULL,
  `bank_name` varchar(134) NOT NULL,
  `bank_txn` varchar(124) NOT NULL,
  `status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ugnon_form_submission`
--

CREATE TABLE `ugnon_form_submission` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `year_exam` varchar(50) NOT NULL,
  `academic_year_id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `term_id` varchar(50) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `date_of_birth` varchar(50) NOT NULL,
  `examination_id` varchar(50) NOT NULL,
  `examination_name` varchar(50) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `college_name` varchar(50) NOT NULL,
  `cc_paper_name` varchar(50) DEFAULT NULL,
  `ge_paper_name` varchar(50) DEFAULT NULL,
  `aecc_paper_name` varchar(50) DEFAULT NULL,
  `created_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `payment_status` int(11) NOT NULL DEFAULT 0,
  `u_id` varchar(50) NOT NULL,
  `payment_activation` int(11) NOT NULL,
  `non_collegiate_status` int(11) NOT NULL DEFAULT 1,
  `email` varchar(50) NOT NULL,
  `default_d_time` datetime NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(11) NOT NULL,
  `pay_mode` varchar(20) DEFAULT NULL,
  `exam_month_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ugnon_payment_details`
--

CREATE TABLE `ugnon_payment_details` (
  `id` int(11) NOT NULL,
  `u_id` varchar(50) NOT NULL,
  `exam_id` varchar(50) NOT NULL,
  `stu_name` varchar(50) NOT NULL,
  `total_fee` varchar(50) NOT NULL,
  `exam_fee` varchar(50) NOT NULL,
  `late_fine` varchar(50) NOT NULL,
  `submit_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `mmp_txn` varchar(50) NOT NULL,
  `mer_txn` varchar(50) NOT NULL,
  `bank_txn` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `prod` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `f_code` varchar(50) NOT NULL,
  `clientcode` varchar(50) NOT NULL,
  `merchant_id` varchar(50) NOT NULL,
  `term_id` varchar(50) DEFAULT NULL,
  `acad_id` int(11) DEFAULT NULL,
  `non_collegiate_status` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_holdbook`
--

CREATE TABLE `user_holdbook` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `empl_id` varchar(100) NOT NULL,
  `username` varchar(80) NOT NULL,
  `ISBN` varchar(100) NOT NULL,
  `book_title` varchar(100) NOT NULL,
  `copies_no` varchar(100) NOT NULL,
  `hold_date` date DEFAULT NULL,
  `issue_request_date` date DEFAULT NULL,
  `direct_issue` int(10) DEFAULT 0,
  `requested_date` datetime NOT NULL DEFAULT current_timestamp(),
  `author` varchar(100) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `edition` varchar(100) NOT NULL,
  `issueReqId` varchar(150) NOT NULL,
  `status` int(10) DEFAULT 0,
  `bookReturndDate` date NOT NULL,
  `bookIssueDate` date NOT NULL,
  `ext_date` date DEFAULT NULL,
  `book_condition` int(10) NOT NULL DEFAULT 1,
  `returnon` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` bigint(20) NOT NULL,
  `empl_id` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `unique_id` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `sess_vlue` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `empl_id`, `last_login`, `ip`, `unique_id`, `status`, `sess_vlue`) VALUES
(1, 'arya0367', '2023-08-17 11:25:17', '::1', '64ddb64597fe978691692251717', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(2, 'arya0367', '2023-08-17 11:28:29', '::1', '64ddb7051b041272531692251909', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(3, 'arya0367', '2023-08-17 11:29:55', '::1', '64ddb75bd7345326331692251995', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(4, 'arya0367', '2023-08-17 11:30:53', '::1', '64ddb7952c8b1107621692252053', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(5, 'arya0367', '2023-08-17 11:31:44', '::1', '64ddb7c896cdb237301692252104', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(6, 'arya0367', '2023-08-17 12:01:11', '::1', '64ddbeaf2e51f186041692253871', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(7, 'arya0367', '2023-08-17 12:04:09', '::1', '64ddbf616ad7e216941692254049', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(8, 'arya0367', '2023-08-17 12:06:25', '::1', '64ddbfe96de89239931692254185', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(9, 'arya0367', '2023-08-17 12:07:43', '::1', '64ddc03741a9d88271692254263', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(10, 'arya0367', '2023-08-17 12:09:36', '::1', '64ddc0a8e9d5b24211692254376', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(11, 'arya0367', '2023-08-17 12:24:05', '::1', '64ddc40dd661267471692255245', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(12, 'arya0367', '2023-08-17 12:25:59', '::1', '64ddc47fc42e889521692255359', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(13, 'arya0367', '2023-08-17 12:34:00', '::1', '64ddc66029724121601692255840', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(14, 'arya0367', '2023-08-17 12:35:37', '::1', '64ddc6c13f8c5270651692255937', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(15, 'arya0367', '2023-08-17 12:36:06', '::1', '64ddc6de47b7d261491692255966', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(16, 'arya0367', '2023-08-17 12:36:18', '::1', '64ddc6eabc11846061692255978', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(17, 'arya0367', '2023-08-17 12:37:15', '::1', '64ddc723ace30302061692256035', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(18, 'arya0367', '2023-08-17 12:40:20', '::1', '64ddc7dc0ec16226801692256220', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(19, 'arya0367', '2023-08-17 12:41:28', '::1', '64ddc820a7c9091691692256288', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(20, 'arya0367', '2023-08-17 12:42:03', '::1', '64ddc843ab55877341692256323', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(21, 'arya0367', '2023-08-17 12:42:47', '::1', '64ddc86f420143111692256367', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(22, 'arya0367', '2023-08-17 12:46:50', '::1', '64ddc962ea68762761692256610', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(23, 'arya0367', '2023-08-17 12:54:38', '::1', '64ddcb364ec24159121692257078', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(24, 'arya0367', '2023-08-17 12:54:49', '::1', '64ddcb4158d6092991692257089', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(25, 'arya0367', '2023-08-17 12:55:17', '::1', '64ddcb5db367c223371692257117', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(26, 'arya0367', '2023-08-17 12:55:32', '::1', '64ddcb6c67259325371692257132', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(27, 'arya0367', '2023-08-17 12:55:54', '::1', '64ddcb826b89494461692257154', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(28, 'arya0367', '2023-08-17 12:57:17', '::1', '64ddcbd5760e479901692257237', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(29, 'arya0367', '2023-08-17 12:57:41', '::1', '64ddcbed10153282151692257261', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(30, 'raushan', '2023-08-17 13:38:00', '::1', '64ddd56077ae78871692259680', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(31, 'raushan', '2023-08-17 14:52:27', '::1', '64dde6d352aa9312711692264147', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(32, 'raushan', '2023-08-17 17:48:30', '::1', '64de1016e694b140351692274710', 1, 'dernke55kh7bmm42bvnadvbfu3'),
(33, 'raushan', '2023-08-18 10:52:10', '::1', '64df00028e15d138591692336130', 1, 'j0vj730r356apik4fsf7r9v523'),
(34, 'raushan', '2023-08-18 12:33:23', '::1', '64df17bba3922144211692342203', 0, 'j0vj730r356apik4fsf7r9v523'),
(35, 'raushan', '2023-08-18 13:40:46', '::1', '64df27860156c37121692346246', 1, 'j0vj730r356apik4fsf7r9v523'),
(36, 'raushan', '2023-08-18 14:42:47', '::1', '64df360f27cdb110611692349967', 1, 'j0vj730r356apik4fsf7r9v523'),
(37, 'raushan', '2023-08-18 16:19:15', '::1', '64df4cabe2bc5153061692355755', 1, 'j0vj730r356apik4fsf7r9v523'),
(38, 'raushan', '2023-08-18 18:19:29', '::1', '64df68d9cf02f84871692362969', 1, 'j0vj730r356apik4fsf7r9v523'),
(39, 'raushan', '2023-08-21 10:19:53', '::1', '64e2ecf14c584318801692593393', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(40, 'raushan', '2023-08-21 12:49:53', '::1', '64e3101990b49268661692602393', 1, '0phq5kqmr40o1biaqnmq80oie6'),
(41, 'admin', '2023-08-21 13:38:15', '::1', '64e31b6f2b69348851692605295', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(42, 'admin', '2023-08-21 13:40:03', '::1', '64e31bdb62acb149471692605403', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(43, 'admin', '2023-08-21 14:00:59', '::1', '64e320c37e24223131692606659', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(44, 'admin', '2023-08-21 14:05:39', '::1', '64e321db39e8a181901692606939', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(45, 'admin', '2023-08-21 14:08:49', '::1', '64e32299d429f227601692607129', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(46, 'admin', '2023-08-21 14:16:45', '::1', '64e3247535615193231692607605', 1, '0phq5kqmr40o1biaqnmq80oie6'),
(47, 'admin', '2023-08-21 15:12:16', '::1', '64e33178a460f198641692610936', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(48, 'admin', '2023-08-21 15:15:18', '::1', '64e3322e71caa300891692611118', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(49, 'admin', '2023-08-21 15:31:17', '::1', '64e335ed6e71193031692612077', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(50, 'admin', '2023-08-21 15:45:00', '::1', '64e33924661d948271692612900', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(51, 'admin', '2023-08-21 15:50:30', '::1', '64e33a6eb63f8296891692613230', 0, '0phq5kqmr40o1biaqnmq80oie6'),
(52, 'admin', '2023-08-21 16:08:01', '::1', '64e33e892a12d182551692614281', 1, '0phq5kqmr40o1biaqnmq80oie6'),
(53, 'admin', '2023-08-22 10:14:10', '::1', '64e43d1ab08fa322591692679450', 0, '2fhj4rp2g2nfjdpfhjf56cf9k4'),
(54, 'admin', '2023-08-22 12:29:06', '::1', '64e45cba289c879301692687546', 1, 'c2vkdl2vqs5d5afko5gu3m8oc3'),
(55, 'admin', '2023-08-23 10:49:46', '127.0.0.1', '64e596f2c69b79819853931692767986', 1, 'tudupm6h9dndekg4kdbi5kklm5'),
(56, 'admin', '2023-08-23 12:18:09', '127.0.0.1', '64e5aba92cba315564792551692773289', 1, 'tudupm6h9dndekg4kdbi5kklm5'),
(57, 'admin', '2023-08-23 15:12:51', '127.0.0.1', '64e5d49b651f014768795971692783771', 1, 'tudupm6h9dndekg4kdbi5kklm5'),
(58, 'admin', '2023-08-23 16:23:13', '127.0.0.1', '64e5e51959a156859837541692787993', 1, 'tudupm6h9dndekg4kdbi5kklm5'),
(59, 'admin', '2023-08-23 17:05:18', '127.0.0.1', '64e5eef6d87ee17778020331692790518', 1, 'tudupm6h9dndekg4kdbi5kklm5'),
(60, 'admin', '2023-08-24 11:40:27', '127.0.0.1', '64e6f4535e4655944227871692857427', 1, 'u1e5f32ubfnespsjace396qn84'),
(61, 'admin', '2023-08-24 12:28:01', '127.0.0.1', '64e6ff7980c542581106151692860281', 1, 'u1e5f32ubfnespsjace396qn84'),
(62, 'admin', '2023-08-24 13:51:06', '127.0.0.1', '64e712f222bdc17461864061692865266', 1, 'u1e5f32ubfnespsjace396qn84'),
(63, 'admin', '2023-08-24 14:35:07', '127.0.0.1', '64e71d431fa7a9364491951692867907', 1, 'u1e5f32ubfnespsjace396qn84'),
(64, 'admin', '2023-08-24 15:06:25', '127.0.0.1', '64e72499bf3a820250674421692869785', 1, 'u1e5f32ubfnespsjace396qn84'),
(65, 'admin', '2023-08-24 15:58:45', '127.0.0.1', '64e730dda128920720171801692872925', 1, 'u1e5f32ubfnespsjace396qn84'),
(66, 'admin', '2023-08-24 16:42:42', '127.0.0.1', '64e73b2a457506647045861692875562', 1, 'u1e5f32ubfnespsjace396qn84'),
(67, 'admin', '2023-08-24 17:17:01', '127.0.0.1', '64e74335b938216421758241692877621', 1, 'u1e5f32ubfnespsjace396qn84'),
(68, 'admin', '2023-08-25 16:15:05', '127.0.0.1', '64e886319217f17986808421692960305', 1, '8481jm3j7uf14988s3ndpgs1v7'),
(69, 'admin', '2023-08-25 16:40:14', '127.0.0.1', '64e88c165a9061149597931692961814', 1, '8481jm3j7uf14988s3ndpgs1v7'),
(70, 'admin', '2023-08-25 18:00:03', '127.0.0.1', '64e89ecb7161c4622658091692966603', 1, '8481jm3j7uf14988s3ndpgs1v7'),
(71, 'admin', '2023-08-28 10:19:09', '127.0.0.1', '64ec2745a584420103593881693198149', 1, 'mvda1h4idglgj03d4d2s8r84e6'),
(72, 'admin', '2023-08-28 11:14:51', '127.0.0.1', '64ec3453d78583984478851693201491', 1, 'mvda1h4idglgj03d4d2s8r84e6'),
(73, 'admin', '2023-08-28 11:49:48', '127.0.0.1', '64ec3c843000712013488201693203588', 1, 'mvda1h4idglgj03d4d2s8r84e6'),
(74, 'admin', '2023-08-28 12:53:30', '127.0.0.1', '64ec4b72375327891788531693207410', 1, 'mvda1h4idglgj03d4d2s8r84e6'),
(75, 'admin', '2023-08-28 14:40:33', '127.0.0.1', '64ec64894c66918417774701693213833', 1, 'mvda1h4idglgj03d4d2s8r84e6'),
(76, 'admin', '2023-08-29 12:03:05', '127.0.0.1', '64ed9121a0f2215387357321693290785', 1, '87fid4912bbos52kvusap72k79'),
(77, 'admin', '2023-08-29 13:20:58', '127.0.0.1', '64eda36251fa514812896181693295458', 1, '87fid4912bbos52kvusap72k79'),
(78, 'admin', '2023-08-29 14:56:11', '127.0.0.1', '64edb9b38888a12370181311693301171', 1, '87fid4912bbos52kvusap72k79'),
(79, 'admin', '2023-08-29 17:03:34', '127.0.0.1', '64edd78e47fd57066871591693308814', 1, '87fid4912bbos52kvusap72k79'),
(80, 'admin', '2023-08-29 17:31:11', '127.0.0.1', '64edde07be2861357167391693310471', 1, '87fid4912bbos52kvusap72k79'),
(81, 'admin', '2023-08-29 17:54:54', '127.0.0.1', '64ede39601d294295495031693311894', 1, '87fid4912bbos52kvusap72k79'),
(82, 'admin', '2023-08-30 12:01:31', '127.0.0.1', '64eee2436073818953602351693377091', 1, '736dge5bl3l4r74c7sn3clcva9'),
(83, 'admin', '2023-08-30 12:34:19', '127.0.0.1', '64eee9f327ff210479381091693379059', 1, '736dge5bl3l4r74c7sn3clcva9'),
(84, 'admin', '2023-08-30 13:03:45', '127.0.0.1', '64eef0d9717c32509264781693380825', 1, '736dge5bl3l4r74c7sn3clcva9'),
(85, 'admin', '2023-08-30 15:11:03', '127.0.0.1', '64ef0eaf491402766024281693388463', 1, '736dge5bl3l4r74c7sn3clcva9'),
(86, 'admin', '2023-08-30 17:25:17', '127.0.0.1', '64ef2e25e3a4d3230159141693396517', 1, '6gd2slh8bqbvoovhmcibiaebvr');

-- --------------------------------------------------------

--
-- Table structure for table `value_added_courses`
--

CREATE TABLE `value_added_courses` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `course_code` varchar(30) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_description` varchar(400) NOT NULL,
  `status` int(11) NOT NULL,
  `academic_year` int(11) NOT NULL,
  `capacity` varchar(50) NOT NULL,
  `conductedby` varchar(100) NOT NULL,
  `tot_credit` varchar(50) NOT NULL,
  `countable` int(11) NOT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `value_added_courses`
--

INSERT INTO `value_added_courses` (`id`, `session_id`, `course_code`, `course_name`, `course_description`, `status`, `academic_year`, `capacity`, `conductedby`, `tot_credit`, `countable`, `semester`) VALUES
(1, 1, 'V101', 'Value Added Course', 'Value added course', 0, 1, '60', '', '6', 0, 't1'),
(2, 2, 'V101', 'Value Added Course', 'Value added course', 0, 2, '60', '', '6', 0, 't1'),
(3, 2, 'r10', 'rausha', 'test', 0, 2, '60', '', '6', 0, 't2');

-- --------------------------------------------------------

--
-- Table structure for table `year_master`
--

CREATE TABLE `year_master` (
  `id` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `year_master`
--

INSERT INTO `year_master` (`id`, `name`, `status`) VALUES
(1, 'First Year', 0),
(2, 'Second Year', 0),
(3, 'Third Year', 0),
(4, 'Fourth Year', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_credits`
--
ALTER TABLE `academic_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `academic_master`
--
ALTER TABLE `academic_master`
  ADD PRIMARY KEY (`academic_year_id`);

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`year_id`);

--
-- Indexes for table `account_master`
--
ALTER TABLE `account_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accu_grade_allocation_items`
--
ALTER TABLE `accu_grade_allocation_items`
  ADD PRIMARY KEY (`grade_allocation_item_id`),
  ADD KEY `grade_allocation_id` (`grade_allocation_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `publish_date` (`publish_date`);

--
-- Indexes for table `addons_ref_grade_manual`
--
ALTER TABLE `addons_ref_grade_manual`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_courses_allotment`
--
ALTER TABLE `addon_courses_allotment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stu_id` (`stu_id`);

--
-- Indexes for table `addon_courses_list`
--
ALTER TABLE `addon_courses_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_course_master`
--
ALTER TABLE `addon_course_master`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `addon_course_master_item`
--
ALTER TABLE `addon_course_master_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_course_mater`
--
ALTER TABLE `addon_course_mater`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_evaluation_componets_master`
--
ALTER TABLE `addon_evaluation_componets_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_evaluation_componets_master_items`
--
ALTER TABLE `addon_evaluation_componets_master_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addon_grade_allocation_items`
--
ALTER TABLE `addon_grade_allocation_items`
  ADD PRIMARY KEY (`grade_allocation_item_id`),
  ADD KEY `grade_allocation_id` (`grade_allocation_id`);

--
-- Indexes for table `addon_grade_allocation_master`
--
ALTER TABLE `addon_grade_allocation_master`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `academic_id` (`academic_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `addon_grade_allocation_report`
--
ALTER TABLE `addon_grade_allocation_report`
  ADD PRIMARY KEY (`grade_report_id`);

--
-- Indexes for table `addon_grade_allocation_report_items`
--
ALTER TABLE `addon_grade_allocation_report_items`
  ADD PRIMARY KEY (`grade_allocation_report_item_id`);

--
-- Indexes for table `addon_marks_sheets`
--
ALTER TABLE `addon_marks_sheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session` (`session`),
  ADD KEY `course_name` (`course_name`);

--
-- Indexes for table `addon_reference_grade_items`
--
ALTER TABLE `addon_reference_grade_items`
  ADD PRIMARY KEY (`reference_item_id`);

--
-- Indexes for table `addon_reference_grade_master`
--
ALTER TABLE `addon_reference_grade_master`
  ADD PRIMARY KEY (`reference_id`);

--
-- Indexes for table `addon_tabulation_report`
--
ALTER TABLE `addon_tabulation_report`
  ADD PRIMARY KEY (`tabl_id`),
  ADD KEY `academic_id` (`academic_id`),
  ADD KEY `academic_id_2` (`academic_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `addon_tabulation_report_items`
--
ALTER TABLE `addon_tabulation_report_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tabl_id` (`tabl_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `alumini_association`
--
ALTER TABLE `alumini_association`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announce_result_items`
--
ALTER TABLE `announce_result_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announce_result_master`
--
ALTER TABLE `announce_result_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_course_details`
--
ALTER TABLE `applicant_course_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_no` (`application_no`),
  ADD KEY `course` (`course`),
  ADD KEY `core_course1` (`core_course1`);

--
-- Indexes for table `applicant_documents_followup`
--
ALTER TABLE `applicant_documents_followup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_no` (`application_no`),
  ADD KEY `application_no_2` (`application_no`),
  ADD KEY `course` (`course`);

--
-- Indexes for table `applicant_educational_details`
--
ALTER TABLE `applicant_educational_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_no` (`application_no`);

--
-- Indexes for table `applicant_fee_account`
--
ALTER TABLE `applicant_fee_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_payement_details`
--
ALTER TABLE `applicant_payement_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_no` (`application_no`),
  ADD KEY `acad_year_id` (`acad_year_id`),
  ADD KEY `payment_status` (`payment_status`),
  ADD KEY `course` (`course`),
  ADD KEY `payementindex` (`course`,`acad_year_id`);

--
-- Indexes for table `applicant_payment_record`
--
ALTER TABLE `applicant_payment_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `application_id` (`application_id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `applicant_paymode_details`
--
ALTER TABLE `applicant_paymode_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form_id` (`form_id`);

--
-- Indexes for table `applicant_personal_details`
--
ALTER TABLE `applicant_personal_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application_no_2` (`application_no`);

--
-- Indexes for table `applicant_registration`
--
ALTER TABLE `applicant_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `apps_countries`
--
ALTER TABLE `apps_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_submitted`
--
ALTER TABLE `assignment_submitted`
  ADD PRIMARY KEY (`submitted_id`);

--
-- Indexes for table `attendance_info`
--
ALTER TABLE `attendance_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_info_master`
--
ALTER TABLE `attendance_info_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `back_grade_allocation_items`
--
ALTER TABLE `back_grade_allocation_items`
  ADD PRIMARY KEY (`grade_allocation_item_id`),
  ADD KEY `grade_allocation_id` (`grade_allocation_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `back_grade_allocation_report_items`
--
ALTER TABLE `back_grade_allocation_report_items`
  ADD PRIMARY KEY (`grade_allocation_report_item_id`);

--
-- Indexes for table `back_selection_items`
--
ALTER TABLE `back_selection_items`
  ADD PRIMARY KEY (`items_id`);

--
-- Indexes for table `back_tabulation_report_items`
--
ALTER TABLE `back_tabulation_report_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_scheduler`
--
ALTER TABLE `batch_scheduler`
  ADD PRIMARY KEY (`batch_schedule_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `class_allotment`
--
ALTER TABLE `class_allotment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_master`
--
ALTER TABLE `class_master`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `componentmaster`
--
ALTER TABLE `componentmaster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `component_grades`
--
ALTER TABLE `component_grades`
  ADD PRIMARY KEY (`component_grade_id`);

--
-- Indexes for table `component_grade_items`
--
ALTER TABLE `component_grade_items`
  ADD PRIMARY KEY (`component_grade_item_id`);

--
-- Indexes for table `configure_selection_process`
--
ALTER TABLE `configure_selection_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_addon_master`
--
ALTER TABLE `core_addon_master`
  ADD PRIMARY KEY (`ccl_id`),
  ADD KEY `academic_year_id` (`academic_year`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `core_course_master`
--
ALTER TABLE `core_course_master`
  ADD PRIMARY KEY (`ccl_id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses_evaluation_components_items`
--
ALTER TABLE `courses_evaluation_components_items`
  ADD PRIMARY KEY (`cr_eci_id`);

--
-- Indexes for table `courses_faculty_allotment_items`
--
ALTER TABLE `courses_faculty_allotment_items`
  ADD PRIMARY KEY (`courses_faculty_allotment_item_id`);

--
-- Indexes for table `courses_grade_allocation_report_items`
--
ALTER TABLE `courses_grade_allocation_report_items`
  ADD PRIMARY KEY (`course_grade_report_item_id`);

--
-- Indexes for table `course_category_master`
--
ALTER TABLE `course_category_master`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indexes for table `course_fee`
--
ALTER TABLE `course_fee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_feed`
--
ALTER TABLE `course_feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_grade_after_penalties`
--
ALTER TABLE `course_grade_after_penalties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_grade_after_penalties_items`
--
ALTER TABLE `course_grade_after_penalties_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `course_master`
--
ALTER TABLE `course_master`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_master_match`
--
ALTER TABLE `course_master_match`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_report`
--
ALTER TABLE `course_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_type_master`
--
ALTER TABLE `course_type_master`
  ADD PRIMARY KEY (`ct_id`);

--
-- Indexes for table `course_wise_grades`
--
ALTER TABLE `course_wise_grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_wise_grade_items`
--
ALTER TABLE `course_wise_grade_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `course_wise_penalties`
--
ALTER TABLE `course_wise_penalties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_wise_penalties_items`
--
ALTER TABLE `course_wise_penalties_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `credit_master`
--
ALTER TABLE `credit_master`
  ADD PRIMARY KEY (`credit_id`);

--
-- Indexes for table `cumulative_marks`
--
ALTER TABLE `cumulative_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stu_id` (`stu_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `academic_year_id` (`academic_year_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `daily_attendance_info`
--
ALTER TABLE `daily_attendance_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_attendance_master`
--
ALTER TABLE `daily_attendance_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_attendance_new`
--
ALTER TABLE `daily_attendance_new`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datatable_master`
--
ALTER TABLE `datatable_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `declared_terms`
--
ALTER TABLE `declared_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degree_info`
--
ALTER TABLE `degree_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_grade_allocation_items`
--
ALTER TABLE `deleted_grade_allocation_items`
  ADD PRIMARY KEY (`grade_allocation_item_id`),
  ADD KEY `grade_allocation_id` (`grade_allocation_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `publish_date` (`publish_date`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_type` (`department_type`);

--
-- Indexes for table `department_type`
--
ALTER TABLE `department_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direct_final_grade_dmi`
--
ALTER TABLE `direct_final_grade_dmi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents_for_admission`
--
ALTER TABLE `documents_for_admission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dtablesetting`
--
ALTER TABLE `dtablesetting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `duration`
--
ALTER TABLE `duration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `electives_evaluation_components_grade_master`
--
ALTER TABLE `electives_evaluation_components_grade_master`
  ADD PRIMARY KEY (`elective_component_grade_id`);

--
-- Indexes for table `employee_allocation_items_master`
--
ALTER TABLE `employee_allocation_items_master`
  ADD PRIMARY KEY (`ead_id`);

--
-- Indexes for table `employee_allotment_master`
--
ALTER TABLE `employee_allotment_master`
  ADD PRIMARY KEY (`ea_id`);

--
-- Indexes for table `empl_dept`
--
ALTER TABLE `empl_dept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `erp_elective_selection`
--
ALTER TABLE `erp_elective_selection`
  ADD PRIMARY KEY (`elective_id`);

--
-- Indexes for table `erp_elective_selection_items`
--
ALTER TABLE `erp_elective_selection_items`
  ADD PRIMARY KEY (`items_id`);

--
-- Indexes for table `erp_fee_category_master`
--
ALTER TABLE `erp_fee_category_master`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `erp_fee_heads_master`
--
ALTER TABLE `erp_fee_heads_master`
  ADD PRIMARY KEY (`feehead_id`);

--
-- Indexes for table `erp_fee_structure_items`
--
ALTER TABLE `erp_fee_structure_items`
  ADD PRIMARY KEY (`items_id`);

--
-- Indexes for table `erp_fee_structure_master`
--
ALTER TABLE `erp_fee_structure_master`
  ADD PRIMARY KEY (`structure_id`);

--
-- Indexes for table `erp_fee_structure_term_items`
--
ALTER TABLE `erp_fee_structure_term_items`
  ADD PRIMARY KEY (`term_items_id`);

--
-- Indexes for table `erp_student_information`
--
ALTER TABLE `erp_student_information`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `evaluation_components_items_master`
--
ALTER TABLE `evaluation_components_items_master`
  ADD PRIMARY KEY (`eci_id`);

--
-- Indexes for table `evaluation_components_master`
--
ALTER TABLE `evaluation_components_master`
  ADD PRIMARY KEY (`ec_id`);

--
-- Indexes for table `fee_collector`
--
ALTER TABLE `fee_collector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_allocation_items`
--
ALTER TABLE `grade_allocation_items`
  ADD PRIMARY KEY (`grade_allocation_item_id`);

--
-- Indexes for table `grade_allocation_log`
--
ALTER TABLE `grade_allocation_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `grade_allocation_master`
--
ALTER TABLE `grade_allocation_master`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `participants_login`
--
ALTER TABLE `participants_login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `reference_grade_master`
--
ALTER TABLE `reference_grade_master`
  ADD PRIMARY KEY (`reference_id`);

--
-- Indexes for table `reference_grade_master_items`
--
ALTER TABLE `reference_grade_master_items`
  ADD PRIMARY KEY (`reference_item_id`);

--
-- Indexes for table `section_master`
--
ALTER TABLE `section_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester_wise_attendance_report`
--
ALTER TABLE `semester_wise_attendance_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session_info`
--
ALTER TABLE `session_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `term_master`
--
ALTER TABLE `term_master`
  ADD PRIMARY KEY (`term_id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `value_added_courses`
--
ALTER TABLE `value_added_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year_master`
--
ALTER TABLE `year_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_master`
--
ALTER TABLE `academic_master`
  MODIFY `academic_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `year_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `account_master`
--
ALTER TABLE `account_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applicant_course_details`
--
ALTER TABLE `applicant_course_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicant_educational_details`
--
ALTER TABLE `applicant_educational_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicant_personal_details`
--
ALTER TABLE `applicant_personal_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicant_registration`
--
ALTER TABLE `applicant_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_info`
--
ALTER TABLE `attendance_info`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_info_master`
--
ALTER TABLE `attendance_info_master`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `componentmaster`
--
ALTER TABLE `componentmaster`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `core_course_master`
--
ALTER TABLE `core_course_master`
  MODIFY `ccl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_category_master`
--
ALTER TABLE `course_category_master`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_master`
--
ALTER TABLE `course_master`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course_type_master`
--
ALTER TABLE `course_type_master`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `credit_master`
--
ALTER TABLE `credit_master`
  MODIFY `credit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_attendance_info`
--
ALTER TABLE `daily_attendance_info`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `daily_attendance_master`
--
ALTER TABLE `daily_attendance_master`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `declared_terms`
--
ALTER TABLE `declared_terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `degree_info`
--
ALTER TABLE `degree_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department_type`
--
ALTER TABLE `department_type`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employee_allocation_items_master`
--
ALTER TABLE `employee_allocation_items_master`
  MODIFY `ead_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_allotment_master`
--
ALTER TABLE `employee_allotment_master`
  MODIFY `ea_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `empl_dept`
--
ALTER TABLE `empl_dept`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `erp_elective_selection`
--
ALTER TABLE `erp_elective_selection`
  MODIFY `elective_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `erp_elective_selection_items`
--
ALTER TABLE `erp_elective_selection_items`
  MODIFY `items_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `erp_fee_category_master`
--
ALTER TABLE `erp_fee_category_master`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `erp_fee_heads_master`
--
ALTER TABLE `erp_fee_heads_master`
  MODIFY `feehead_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `erp_fee_structure_items`
--
ALTER TABLE `erp_fee_structure_items`
  MODIFY `items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `erp_fee_structure_master`
--
ALTER TABLE `erp_fee_structure_master`
  MODIFY `structure_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `erp_fee_structure_term_items`
--
ALTER TABLE `erp_fee_structure_term_items`
  MODIFY `term_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `erp_student_information`
--
ALTER TABLE `erp_student_information`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `evaluation_components_items_master`
--
ALTER TABLE `evaluation_components_items_master`
  MODIFY `eci_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `evaluation_components_master`
--
ALTER TABLE `evaluation_components_master`
  MODIFY `ec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fee_collector`
--
ALTER TABLE `fee_collector`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grade_allocation_items`
--
ALTER TABLE `grade_allocation_items`
  MODIFY `grade_allocation_item_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grade_allocation_log`
--
ALTER TABLE `grade_allocation_log`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grade_allocation_master`
--
ALTER TABLE `grade_allocation_master`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `participants_login`
--
ALTER TABLE `participants_login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reference_grade_master`
--
ALTER TABLE `reference_grade_master`
  MODIFY `reference_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reference_grade_master_items`
--
ALTER TABLE `reference_grade_master_items`
  MODIFY `reference_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `section_master`
--
ALTER TABLE `section_master`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `semester_wise_attendance_report`
--
ALTER TABLE `semester_wise_attendance_report`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `session_info`
--
ALTER TABLE `session_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `term_master`
--
ALTER TABLE `term_master`
  MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `value_added_courses`
--
ALTER TABLE `value_added_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `year_master`
--
ALTER TABLE `year_master`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
