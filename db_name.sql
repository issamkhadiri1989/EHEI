-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : sam. 30 jan. 2021 à 22:29
-- Version du serveur :  5.7.32
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_name`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `article_cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `body`, `author_id`, `article_cover`) VALUES
(5, 'Blanditiis qui qui consequuntur rerum tenetur est facere et ut.', 'Ipsa velit et nesciunt qui. Iusto recusandae illo tempora rerum perspiciatis eum. At at qui sit repellat. Perspiciatis labore corrupti iure quia sunt recusandae molestiae. Non eum quis vel eveniet est pariatur nobis. Ullam tempora et qui dolorem voluptatem repudiandae est. Atque nemo esse sit asperiores ea consectetur. Ut omnis culpa tenetur occaecati rem libero. Laudantium dolores exercitationem nemo alias est. Est mollitia in consequatur nobis sint maiores. Ut corrupti dolor quibusdam minus nihil ex et.', 10, '6015db47abe87.png'),
(6, 'Suscipit ut rerum ullam voluptate est ad commodi omnis eos at error sequi provident aliquam non assumenda accusantium.', 'Deserunt enim perspiciatis tempora distinctio quae est. Voluptatem tenetur ut aut velit. Enim fugit est tempore cumque aperiam amet autem. Corrupti aspernatur illo dolores inventore nihil alias. Dicta nihil ipsum voluptate libero voluptatem. Nulla est et vitae tempore consequatur at. Temporibus sint perferendis amet sequi. Sit reiciendis molestiae rerum. Quos consequatur qui sunt dolor amet. Pariatur laborum rerum autem magni. Natus nihil voluptate aut reprehenderit et cum impedit. Sit ut facilis quo totam excepturi. Rerum impedit et accusantium tempore rerum. Eos iste aut expedita rerum sed odio. Est reiciendis impedit enim. Corrupti voluptatum ut fugiat eligendi illo. Voluptatibus natus a libero. Facilis ipsa dicta sed. Explicabo amet voluptates ut nobis et. Voluptatum voluptatum est hic vitae. Veniam voluptatibus iusto quis aliquid non voluptas. Est et dolores odit expedita est. Cum et sint ut deleniti omnis. Velit earum neque mollitia sed odio dignissimos sit exercitationem. Aliquid laborum sed qui. Porro est minima vel. Deleniti est neque quaerat non. Impedit repudiandae odio quia vero tempora. Rerum perferendis cum modi est autem qui. Voluptas culpa eos voluptatem doloribus. Velit pariatur dolore aut itaque numquam libero quas. Nihil dolorem voluptatem impedit qui enim est.', 11, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210130200134', '2021-01-30 20:02:18', 938),
('DoctrineMigrations\\Version20210130201014', '2021-01-30 20:10:22', 662),
('DoctrineMigrations\\Version20210130201719', '2021-01-30 20:17:30', 3709);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(10, 'user1', '[]', '$argon2id$v=19$m=65536,t=4,p=1$+WpQQz8KG43kajMoGR0duQ$+0SzW99Jcl/TFC9NFe6gknMSZSaLpKxljfgJVBIyv+w'),
(11, 'user3', '[]', '$argon2id$v=19$m=65536,t=4,p=1$GsYKc5Z49zvf/pz/Jz50Sw$XZoXG4UBXQaiw7e88XTKR7gjJauxUFEX86JKAETrjU8');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E66F675F31B` (`author_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
