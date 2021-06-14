<?php

// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProgramController
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * Correspond à la route /programs/ et au name "program_index"
     * @Route("/", name="index")
     * * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    /**
     * Getting a program by id
     *
     * @Route("/show/{id<\d+>}", methods={"GET"}, name="show")
     * @return Response
     */
    public function show(Program $program): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $program]);

        if (!$program) {
            throw $this->createNotFoundException(
                'Aucune serie avec l\identifiant : ' . $program . ' trouvé dans la liste.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    /**
     * @Route("/{programId}/season/{seasonId}", methods={"GET"}, name="season_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId":"id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId":"id"}})
     * @return Response
     */
    public function showSeason(Program $program, Season $season): response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $program]);

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $season]);

        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['season' => $season]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
        ]);
    }
    /**
     * @Route("/{programId}/season/{seasonId}/episode/{episodeId}", methods={"GET"}, name="episode_show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"programId":"id"}})
     * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"seasonId":"id"}})
     * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episodeId":"id"}})
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $program]);

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => $season]);

        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['id' => $episode]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
        ]);
    }
}
