# moodle-local_noactivitiesnotemptyactualcourses
Local plugin which extends the one who was created at the MoodleMoot 2018 in Germany as part of a spontaneous DevCamp about the new Moodle Analytics API.

The created target selects all courses, which consists of only resource modules and a forum. It focuses, aditionally, that there is (at least) a lecturer and (at least) a student enroled, and that the actual date is between the course startdate and the course enddate so not to trigger unused courses.

Additionally, it does notify just the main administrator since manager who are not yet informed of analytics will not get mail notifications leaving them perplex.
