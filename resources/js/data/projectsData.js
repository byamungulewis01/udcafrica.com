const projectsData = [
  {
    id: "udc-project-1",
    title: "Bugesera Family Residence",
    category: "Uncategorized",
    location: "Bugesera, Rwanda",
    year: "20th July 2025",
    size: "210 Sqm",
    client: "Kigali Heights Ltd",
    architect: "UDC Africa Ltd",
    featured: true,
    coverImage: "/UDC-Project-1.jpg",
    shortDescription: "This single-storied residential home is designed for modern family living with a focus on comfort, efficiency, and simplicity. Located in the growing district of towards Bugesera International Airport, the house offers a practical yet stylish layout tailored to everyday needs.",
    description: "",
    details: "The home features three well-sized bedrooms, an open-concept kitchen and living area that enhances natural light and connectivity, and a spacious backyard ideal for outdoor relaxation or future expansion. The design emphasizes both functionality and ease of maintenance, making it perfect for family life in a suburban setting.",
    gallery: [
      "/UDC-Project-1-A.jpg",
      "/UDC-Project-1-B.jpg",
      "/UDC-Project-1-C.jpg",
      "/UDC-Project-1-D.jpg"
    ],
    awards: ""
  },
  {
    id: "bugesera-airport",
    title: "Bugesera International Airport",
    category: "Commercial",
    location: "Bugesera, Rwanda",
    year: "2023",
    size: "30,000 sq m",
    client: "Rwanda Civil Aviation Authority",
    architect: "UDC Africa Engineering",
    featured: true,
    coverImage: "https://images.pexels.com/photos/380768/pexels-photo-380768.jpeg?auto=compress&cs=tinysrgb&w=1600",
    shortDescription: "State-of-the-art international airport with advanced engineering solutions.",
    description: "A major infrastructure project featuring innovative structural engineering and sustainable systems integration.",
    details: "The project showcases advanced engineering solutions including a long-span roof structure, integrated building systems, and sustainable energy solutions. The terminal building incorporates passive cooling strategies and rainwater harvesting systems.",
    gallery: [
      "https://images.pexels.com/photos/425242/pexels-photo-425242.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/380768/pexels-photo-380768.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/4050318/pexels-photo-4050318.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/373965/pexels-photo-373965.jpeg?auto=compress&cs=tinysrgb&w=1600"
    ],
    awards: "2023 Engineering Excellence Award"
  },
  {
    id: "vision-city",
    title: "Vision City Master Plan",
    category: "Cultural",
    location: "Kigali, Rwanda",
    year: "2021",
    size: "157 hectares",
    client: "City of Kigali",
    architect: "UDC Africa Planning",
    featured: true,
    coverImage: "https://images.pexels.com/photos/461902/pexels-photo-461902.jpeg?auto=compress&cs=tinysrgb&w=1600",
    shortDescription: "Comprehensive urban development plan for a new sustainable district.",
    description: "A visionary master plan creating a new urban district with mixed-use developments, green spaces, and sustainable infrastructure.",
    details: "The master plan includes residential areas, commercial zones, educational facilities, and integrated green corridors. Special attention was paid to pedestrian connectivity, public transportation integration, and sustainable urban drainage systems.",
    gallery: [
      "https://images.pexels.com/photos/1674049/pexels-photo-1674049.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/1125212/pexels-photo-1125212.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/3004909/pexels-photo-3004909.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/2835863/pexels-photo-2835863.jpeg?auto=compress&cs=tinysrgb&w=1600"
    ],
    awards: "2022 Urban Planning Excellence Award"
  },
  {
    id: "convention-center",
    title: "Kigali Convention Center",
    category: "Urban Planning",
    location: "Kigali, Rwanda",
    year: "2022",
    size: "32,000 sq m",
    client: "Government of Rwanda",
    architect: "Project Management Team",
    featured: true,
    coverImage: "https://images.pexels.com/photos/449627/pexels-photo-449627.jpeg?auto=compress&cs=tinysrgb&w=1600",
    shortDescription: "Complex project management of a major convention center development.",
    description: "Successful delivery of a large-scale convention center project, managing multiple stakeholders and complex construction phases.",
    details: "The project involved coordination of international contractors, local workforce development, and strict quality control measures. Innovative project management techniques ensured on-time delivery within budget.",
    gallery: [
      "https://images.pexels.com/photos/1167021/pexels-photo-1167021.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/417351/pexels-photo-417351.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/158028/pexels-photo-158028.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/158063/pexels-photo-158063.jpeg?auto=compress&cs=tinysrgb&w=1600"
    ],
    awards: "2023 Project Management Achievement Award"
  },
  {
    id: "commercial-portfolio",
    title: "Commercial Portfolio Valuation",
    category: "Residential",
    location: "East Africa Region",
    year: "2023",
    size: "Multiple Properties",
    client: "Regional Banking Group",
    architect: "Valuation Team",
    featured: false,
    coverImage: "https://images.pexels.com/photos/280222/pexels-photo-280222.jpeg?auto=compress&cs=tinysrgb&w=1600",
    shortDescription: "Comprehensive valuation of commercial property portfolio across East Africa.",
    description: "Expert valuation services for a major banking group's commercial property portfolio, including office buildings, retail centers, and industrial facilities.",
    details: "The valuation process included detailed market analysis, income approach calculations, and consideration of regional economic factors. The team provided comprehensive reports meeting international valuation standards.",
    gallery: [
      "https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/271795/pexels-photo-271795.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/3935350/pexels-photo-3935350.jpeg?auto=compress&cs=tinysrgb&w=1600"
    ],
    awards: "2023 Valuation Excellence Award"
  },
  {
    id: "hospital-project",
    title: "National Referral Hospital",
    category: "Commercial",
    location: "Kigali, Rwanda",
    year: "2023",
    size: "45,000 sq m",
    client: "Ministry of Health",
    architect: "Quantity Surveying Team",
    featured: false,
    coverImage: "https://images.pexels.com/photos/1098982/pexels-photo-1098982.jpeg?auto=compress&cs=tinysrgb&w=1600",
    shortDescription: "Detailed quantity surveying for major healthcare facility.",
    description: "Comprehensive quantity surveying services for the construction of a new national referral hospital, including cost planning, procurement advice, and contract administration.",
    details: "The team provided detailed cost estimates, bill of quantities, and value engineering recommendations. Regular cost monitoring and reporting ensured project delivery within budget constraints.",
    gallery: [
      "https://images.pexels.com/photos/267507/pexels-photo-267507.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/260931/pexels-photo-260931.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/163806/pexels-photo-163806.jpeg?auto=compress&cs=tinysrgb&w=1600",
      "https://images.pexels.com/photos/3182835/pexels-photo-3182835.jpeg?auto=compress&cs=tinysrgb&w=1600"
    ],
    awards: "2023 Quantity Surveying Excellence Award"
  }
];

export default projectsData;