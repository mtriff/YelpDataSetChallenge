YelpDataSetChallenge
====================

GitHub project containing the files used in submission for the Yelp Dataset Challenge (2013)

The project was completed, and then later uploaded to GitHub, as such, the file paths for file I/O will not align.  Database passwords have also been removed.

Abstract
========

The project uses a novel recursive meta-profiling technique where profiles from one set of objects dynamically change the representation of another
set of objects. Two profiling schemes evolve in parallel influencing each other through indirect recursion, and is demonstrated with Yelp Academic Dataset, consisting of businesses and reviewers. A business is represented by static information obtained from the database and dynamic information obtained from clustering of reviewers who have reviewed the business. Similarly, the reviewer representation augments the static representation from the database with profiles of businesses who are reviewed by these reviewers. The resulting service provides a facility for users to find similar businesses/reviewers based on the grading of the business, easy/hard grading, and types of businesses. It also provides a succinct profile of a business/reviewer based on these factors, so users can put the reviews in context.

A tutorial video on how this representation is created, along with a demonstration of the usefulness of this data-mining, can be found at http://www.mtriff.com/yelp/video.php

Data Mining
===========

The data-preparation, data-mining, and meta-clustering was completed through the use of Python, R, and shell scripts.  All of which may be found within the 'src' folder.

All the original and generated data can be found under the 'data' folder.

An academic paper, describing the meta-clustering technique applied, can be found at http://www.mtriff.com/yelp/academicPaper.pdf

Front End
=========

The front end website, demonstrating the usefulness of the meta-clustering, was written in HTML, JavaScript, CSS, and PHP.  It also uses Twitter Bootstrap 2.3 and a MySQL database backend.

The files for the front end can be found in the 'web' folder, and the site is live at http://www.mtriff.com/yelp
