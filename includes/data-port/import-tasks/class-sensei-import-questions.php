<?php
/**
 * File containing the Sensei_Import_Questions class.
 *
 * @package sensei
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class handles the import task for questions.
 */
class Sensei_Import_Questions
	extends Sensei_Import_File_Process_Task
	implements Sensei_Data_Port_Task_Interface {

	/**
	 * Return a unique key for the task.
	 *
	 * @return string
	 */
	public function get_task_key() {
		return 'questions';
	}

	/**
	 * Process a single CSV line.
	 *
	 * @param int   $line_number  The line number in the file.
	 * @param array $line         The current line as returned from Sensei_Import_CSV_Reader::read_lines().
	 *
	 * @return mixed
	 */
	protected function process_line( $line_number, $line ) {
		$model = Sensei_Data_Port_Question_Model::from_source_array( $line );
		if ( ! $model->is_valid() ) {
			// @todo Mark as skipped.

			return false;
		}

		if ( ! $model->sync_post() ) {
			// @todo Mark as failed.

			return false;
		}

		// @todo Mark as successful.

		return true;
	}

	/**
	 * Performs any required cleanup of the task.
	 */
	public function clean_up() {
		// @todo Implement.
	}

	/**
	 * Validate an uploaded source file before saving it.
	 *
	 * @param string $file_path File path of the file to validate.
	 *
	 * @return true|WP_Error
	 */
	public static function validate_source_file( $file_path ) {
		$required_fields = Sensei_Data_Port_Question_Model::get_required_fields();
		$optional_fields = Sensei_Data_Port_Question_Model::get_optional_fields();

		return Sensei_Import_CSV_Reader::validate_csv_file( $file_path, $required_fields, $optional_fields );
	}
}