export const blogs1 = [
  {
    id: 1,
    imageSrc: "/assets/img/photos/b4.jpg",
    imageAlt: "Image Alt 1",

    category: "Coding",

    postTitle: "Ligula tristique quis risus",

    postDate: "14 Apr 2022",
    likes: 2,
    comments: 4,
    desc: `Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor.`,
  },
  {
    id: 2,
    imageSrc: "/assets/img/photos/b5.jpg",
    imageAlt: "Image Alt 2",

    category: "Workspace",

    postTitle: "Nullam id dolor elit id nibh",

    postDate: "29 Mar 2022",
    likes: 2,
    comments: 3,

    desc: `Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor.`,
  },
  {
    id: 3,
    imageSrc: "/assets/img/photos/b6.jpg",
    imageAlt: "Image Alt 3",

    category: "Meeting",

    postTitle: "Ultricies fusce porta elit",

    postDate: "26 Feb 2022",
    likes: 2,
    comments: 6,
    desc: `Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor.`,
  },
  {
    id: 4,
    imageSrc: "/assets/img/photos/b7.jpg",
    imageAlt: "Image Alt 4",

    category: "Business Tips",

    postTitle: "Morbi leo risus porta eget",

    postDate: "7 Jan 2022",
    likes: 2,
    comments: 2,
    desc: `Mauris convallis non ligula non interdum. Gravida vulputate convallis tempus vestibulum cras imperdiet nun eu dolor.`,
  },
];

export const comments = [
  {
    id: 1,
    avatar: "/assets/img/avatars/u1.jpg",
    author: "Connor Gibson",
    authorLink: "#",
    date: "14 Jan 2022",
    content:
      "Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum...",
  },
  {
    id: 2,
    avatar: "/assets/img/avatars/u2.jpg",
    author: "Nikolas Brooten",
    authorLink: "#",
    date: "21 Feb 2022",
    content:
      "Quisque tristique tincidunt metus non aliquam. Quisque ac risus sit amet quam sollicitudin vestibulum...",
    children: [
      {
        id: 3,
        avatar: "/assets/img/avatars/u3.jpg",
        author: "Pearce Frye",
        authorLink: "#",
        date: "22 Feb 2022",
        content:
          "Cras mattis consectetur purus sit amet fermentum. Integer posuere erat a ante venenatis dapibus posuere velit aliquet...",
        children: [
          {
            id: 4,
            avatar: "/assets/img/avatars/u2.jpg",
            author: "Nikolas Brooten",
            authorLink: "#",
            date: "4 Apr 2022",
            content:
              "Nullam id dolor id nibh ultricies vehicula ut id. Cras mattis consectetur purus sit amet fermentum. Aenean eu leo quam...",
          },
        ],
      },
    ],
  },
  {
    id: 5,
    avatar: "/assets/img/avatars/u4.jpg",
    author: "Lou Bloxham",
    authorLink: "#",
    date: "3 May 2022",
    content:
      "Sed posuere consectetur est at lobortis. Vestibulum id ligula porta felis euismod semper. Cum sociis natoque penatibus et magnis...",
  },
];
