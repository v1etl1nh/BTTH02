CREATE TABLE `cms_user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
);

CREATE TABLE `cms_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
)

CREATE TABLE `cms_posts` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `message` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `status` enum('published','draft','archived','') NOT NULL DEFAULT 'published',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp()
)
