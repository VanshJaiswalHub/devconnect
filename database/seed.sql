-- DevConnect demo seed data

INSERT INTO users
    (id, username, email, password, developer_role, experience_years)
VALUES
    (1, 'Leon', 'leon@demo.dev',
     '$2y$10$WC/SVA10QAceWqoYEFnZjupn64wlJ716V9xQ5ktsaFYQeFXeOlyym',
     'Frontend Developer', 4),

    (2, 'Jack', 'jack@demo.dev',
     '$2y$10$5rxLI6.O5jHDeV/Uigbiv.Q0Mwk/03se.x0TPnNkPOBwF3Y38xLju',
     'Full Stack Developer', 5),

    (3, 'Tobey', 'tobey@demo.dev',
     '$2y$10$96Z33XVBC15e9CTprnaxkuCW20pFi5ityaDd.liAGH8ZJ4n12SqR.',
     'PHP Developer', 0);


INSERT INTO posts
    (id, user_id, content, image_path)
VALUES
    (1, 1, 'Good day to you all. Excited to build something new.', 'assets/images/demo_posts/laptop-workspace.jpg'),

    (2, 2, 'Working on a new full-stack project. Looking forward to learning more.', 'assets/images/demo_posts/coding-setup.jpg'),

    (3, 3, 'Just getting started with PHP development.', NULL);


INSERT INTO follows
    (id, follower_id, following_id)
VALUES
    (1, 1, 2),
    (2, 3, 1);