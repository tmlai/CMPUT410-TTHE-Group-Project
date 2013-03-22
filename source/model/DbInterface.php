<?php
interface DbInterface {
	/*
	 * Return a list of categories
	 * Return type: array of category objects
	 */
	public function getCategoriesList();

	/*
	 * Return a list of products belonging to some category
	 * Parameters: $categoryId 	the id of the category
	 * Return type: array of product objects
	 */
	public function getProducts($categoryId);

}
?>